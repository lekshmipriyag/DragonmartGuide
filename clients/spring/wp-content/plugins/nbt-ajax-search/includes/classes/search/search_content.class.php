<?php
/* Prevent direct access */
defined( 'ABSPATH' ) or die( "You can't access this file directly." );

if ( ! class_exists( 'wpnetbase_searchContent' ) ) {
	class wpnetbase_searchContent extends wpnetbase_search {

		protected function do_search() {
			global $wpdb;
			global $q_config;

			$options        = $this->options;
            $comp_options   = get_option( 'asl_compatibility' );
			$searchData     = $this->searchData;
			$sd     = &$searchData;

			$parts           = array();
			$relevance_parts = array();
			$types           = array();
			$post_types      = "";
			$term_query      = "(1)";
			$post_statuses   = "";
			$term_join       = "";
			$postmeta_join   = "";

            // Prefixes and suffixes
            $pre_field = '';
            $suf_field = '';
            $pre_like  = '';
            $suf_like  = '';

			$kw_logic = $sd['keyword_logic'];
			$op = strtoupper( $kw_logic );

            /**
             *  On forced case sensitivity: Let's add BINARY keyword before the LIKE
             *  On forced case in-sensitivity: Append the lower() function around each field
             */
            if ( w_isset_def( $comp_options['db_force_case'], 'none' ) == 'sensitivity' ) {
                $pre_like = 'BINARY ';
            } else if ( w_isset_def( $comp_options['db_force_case'], 'none' ) == 'insensitivity' ) {
                if ( function_exists( 'mb_convert_case' ) ) {
                    $this->s = mb_convert_case( $this->s, MB_CASE_LOWER, "UTF-8" );
                } else {
                    $this->s = strtoupper( $this->s );
                } // if no mb_ functions :(
                $this->_s = array_unique( explode( " ", $this->s ) );

                $pre_field .= 'lower(';
                $suf_field .= ')';
            }

            /**
             *  Check if utf8 is forced on LIKE
             */
            if ( w_isset_def( $comp_options['db_force_utf8_like'], 0 ) == 1 ) {
                $pre_like .= '_utf8';
            }

            /**
             *  Check if unicode is forced on LIKE, but only apply if utf8 is not
             */
            if ( w_isset_def( $comp_options['db_force_unicode'], 0 ) == 1
                && w_isset_def( $comp_options['db_force_utf8_like'], 0 ) == 0
            ) {
                $pre_like .= 'N';
            }

            $s  = $this->s; // full keyword
            $_s = $this->_s;    // array of keywords

			if (isset($options['non_ajax_search']))
				$this->remaining_limit = 500;
			else
				$this->remaining_limit = $searchData['maxresults'];

			$q_config['language'] = $options['qtranslate_lang'];

			/*------------------------- Statuses ----------------------------*/
			$post_statuses = "( $wpdb->posts.post_status = 'publish')";
			/*---------------------------------------------------------------*/

			/*----------------------- Gather Types --------------------------*/
			//var_dump($options);
			if ($options['set_inposts'] == 1)
				$types[] = "post";
			if ($options['set_inpages'])
				$types[] = "page";
			if (isset($options['customset']) && count($options['customset']) > 0)
				$types = array_merge($types, $options['customset']);
			if (count($types) < 1) {
				return '';
			} else {
				$words = implode("','", $types);
				$post_types = "($wpdb->posts.post_type IN ('$words') )";
			}
			/*---------------------------------------------------------------*/

			/*----------------------- Title query ---------------------------*/
			if ( $options['set_intitle'] ) {
				$words = $options['set_exactonly'] == 1 ? array( $s ) : $_s;
				//$parts[] = "(lower($wpdb->posts.post_title) REGEXP '$words')";

                if ( count( $_s ) > 0 ) {
                    $_like = implode( "%'$suf_like " . $op . " " . $pre_field . $wpdb->posts . ".post_title" . $suf_field . " LIKE $pre_like'%", $words );
                } else {
                    $_like = $s;
                }
                $parts[] = "( " . $pre_field . $wpdb->posts . ".post_title" . $suf_field . " LIKE $pre_like'%" . $_like . "%'$suf_like )";

                $relevance_parts[] = "(case when
                (" . $pre_field . $wpdb->posts . ".post_title" . $suf_field . " LIKE '%$s%')
                 then 10 else 0 end)";

                // The first word relevance is higher
                if ( count( $_s ) > 0 ) {
                    $relevance_parts[] = "(case when
                  (" . $pre_field . $wpdb->posts . ".post_title" . $suf_field . " LIKE '%" . $_s[0] . "%')
                   then 10 else 0 end)";
                }
			}
			/*---------------------------------------------------------------*/

			/*---------------------- Content query --------------------------*/
			if ( $options['set_incontent'] ) {
				$words = $options['set_exactonly'] == 1 ? array( $s ) : $_s;
				//$parts[] = "(lower($wpdb->posts.post_content) REGEXP '$words')";

                if ( count( $_s ) > 0 ) {
                    $_like = implode( "%'$suf_like " . $op . " " . $pre_field . $wpdb->posts . ".post_content" . $suf_field . " LIKE $pre_like'%", $words );
                } else {
                    $_like = $s;
                }
                $parts[] = "( " . $pre_field . $wpdb->posts . ".post_content" . $suf_field . " LIKE $pre_like'%" . $_like . "%'$suf_like )";

                if ( count( $_s ) > 0 ) {
                    $relevance_parts[] = "(case when
                    (" . $pre_field . $wpdb->posts . ".post_content" . $suf_field . " LIKE '%" . $_s[0] . "%')
                     then 8 else 0 end)";
                }
                $relevance_parts[] = "(case when
                (" . $pre_field . $wpdb->posts . ".post_content" . $suf_field . " LIKE '%$s%')
                 then 8 else 0 end)";
			}
			/*---------------------------------------------------------------*/

			/*----------------- Permalink, post_name query ------------------*/
			if ( $sd['search_in_permalinks'] ) {
				$words = $options['set_exactonly'] == 1 ? array($s) : $_s;

				if (count($_s) > 0) {
					$_like = implode("%'$suf_like " . $op . " " . $pre_field . $wpdb->posts . ".post_name" . $suf_field . " LIKE $pre_like'%", $words);
				} else {
					$_like = $s;
				}
				$parts[] = "( " . $pre_field . $wpdb->posts . ".post_name" . $suf_field . " LIKE $pre_like'%" . $_like . "%'$suf_like )";
			}
			/*---------------------------------------------------------------*/

			/*---------------------- Excerpt query --------------------------*/
			if ( $options['set_inexcerpt'] ) {
				$words = $options['set_exactonly'] == 1 ? array( $s ) : $_s;
				//$parts[] = "(lower($wpdb->posts.post_excerpt) REGEXP '$words')";

                if ( count( $_s ) > 0 ) {
                    $_like = implode( "%'$suf_like " . $op . " " . $pre_field . $wpdb->posts . ".post_excerpt" . $suf_field . " LIKE $pre_like'%", $words );
                } else {
                    $_like = $s;
                }
                $parts[] = "( " . $pre_field . $wpdb->posts . ".post_excerpt" . $suf_field . " LIKE $pre_like'%" . $_like . "%'$suf_like )";

                if ( count( $_s ) > 0 ) {
                    $relevance_parts[] = "(case when
                    (" . $pre_field . $wpdb->posts . ".post_excerpt" . $suf_field . " LIKE '%" . $_s[0] . "%')
                     then 7 else 0 end)";
                }
                $relevance_parts[] = "(case when
                (" . $pre_field . $wpdb->posts . ".post_excerpt" . $suf_field . " LIKE '%$s%')
                 then 7 else 0 end)";
			}
			/*---------------------------------------------------------------*/

			/*------------------------ Term query ---------------------------*/
			if ( $options['searchinterms'] ) {
				$words = $options['set_exactonly'] == 1 ? array( $s ) : $_s;
				//$parts[] = "(lower($wpdb->terms.name) REGEXP '$words')";

                if ( count( $_s ) > 0 ) {
                    $_like = implode( "%'$suf_like " . $op . " " . $pre_field . $wpdb->terms . ".name" . $suf_field . " LIKE $pre_like'%", $words );
                } else {
                    $_like = $s;
                }
                $parts[] = "( " . $pre_field . $wpdb->terms . ".name" . $suf_field . " LIKE $pre_like'%" . $_like . "%'$suf_like )";

                $relevance_parts[] = "(case when
                (" . $pre_field . $wpdb->terms . ".name" . $suf_field . " = '$s')
                 then 5 else 0 end)";
			}
			/*---------------------------------------------------------------*/

			/*---------------------- Custom Fields --------------------------*/
			if ( $sd['search_all_cf'] == 1 ) {
				$words = $options['set_exactonly'] == 1 ? array( $s ) : $_s;
				if ( count( $_s ) > 0 ) {
					$_like = implode( "%'$suf_like " . $op . " " . $pre_field . $wpdb->postmeta . ".meta_value" . $suf_field . " LIKE $pre_like'%", $words );
				} else {
					$_like = $s;
				}
				$parts[] = "(  " . $pre_field . $wpdb->postmeta . ".meta_value" . $suf_field . " LIKE $pre_like'%" . $_like . "%'$suf_like )";
				$postmeta_join = "LEFT JOIN $wpdb->postmeta ON $wpdb->postmeta.post_id = $wpdb->posts.ID";
			} else if ( isset( $searchData['selected-customfields'] ) ) {
				$selected_customfields = $searchData['selected-customfields'];
				if ( is_array( $selected_customfields ) && count( $selected_customfields ) > 0 ) {
					$words = $options['set_exactonly'] == 1 ? array( $s ) : $_s;

					foreach ( $selected_customfields as $cfield ) {
						if ( count( $_s ) > 0 ) {
							$_like = implode( "%'$suf_like " . $op . " " . $pre_field . $wpdb->postmeta . ".meta_value" . $suf_field . " LIKE $pre_like'%", $words );
						} else {
							$_like = $s;
						}
						$parts[] = "( $wpdb->postmeta.meta_key='$cfield' AND " . $pre_field . $wpdb->postmeta . ".meta_value" . $suf_field . " LIKE $pre_like'%" . $_like . "%'$suf_like )";
					}
					$postmeta_join = "LEFT JOIN $wpdb->postmeta ON $wpdb->postmeta.post_id = $wpdb->posts.ID";

				}
			}
			/*---------------------------------------------------------------*/


			// ------------------------ Categories/taxonomies ----------------------
			/*if (
				w_isset_def($searchData['showsearchincategories'], 0) == 1 &&
				w_isset_def($searchData['show_frontend_search_settings'], 1) == 1
			) {
			  if (!isset($options['categoryset']) || $options['categoryset'] == "")
				  $options['categoryset'] = array();
			  if (!isset($options['termset']) || $options['termset'] == "")
				  $options['termset'] = array();

			  $exclude_categories = array();
			  $searchData['selected-exsearchincategories'] = w_isset_def($searchData['selected-exsearchincategories'], array());
			  $searchData['selected-excludecategories'] = w_isset_def($searchData['selected-excludecategories'], array());
			  $_all_cat = get_all_category_ids();
			  $_needed_cat = array_diff($_all_cat, $searchData['selected-exsearchincategories']);
			  $_needed_cat = !is_array($_needed_cat)?array():$_needed_cat;
			  $exclude_categories = array_diff(array_merge($_needed_cat, $searchData['selected-excludecategories']), $options['categoryset']);

			  $exclude_terms = array();
			  $exclude_showterms = array();
			  $searchData['selected-showterms'] = w_isset_def($searchData['selected-showterms'], array());
			  $searchData['selected-excludeterms'] = w_isset_def($searchData['selected-excludeterms'], array());
			  foreach ($searchData['selected-excludeterms'] as $tax=>$terms) {
				  $exclude_terms = array_merge($exclude_terms, $terms);
			  }
			  foreach ($searchData['selected-showterms'] as $tax=>$terms) {
				  $exclude_showterms = array_merge($exclude_showterms, $terms);
			  }

			  $exclude_terms = array_diff(array_merge($exclude_terms, $exclude_showterms), $options['termset']);

			  $all_terms = array();
			  $all_terms = array_merge($exclude_categories, $exclude_terms);
			  if (count($all_terms) > 0) {
				  $words = '--'.implode('--|--', $all_terms).'--';
				  $term_query = "HAVING (ttid NOT REGEXP '$words')";
			  }
			} else {
			   $ex_cat = w_isset_def($searchData['selected-excludecategories'], array());
				if (count($ex_cat) > 0) {
					$words = '--'.implode('--|--', $ex_cat).'--';
					$term_query = "HAVING (ttid NOT REGEXP '$words')";
				}
			}*/
			// ---------------------------------------------------------------------


			// ------------------------ Categories/taxonomies ----------------------
			if ( ! isset( $options['categoryset'] ) || $options['categoryset'] == "" ) {
				$options['categoryset'] = array();
			}
			if ( ! isset( $options['termset'] ) || $options['termset'] == "" ) {
				$options['termset'] = array();
			}

			$term_logic = 'and';

			$exclude_categories                          = array();
			$searchData['selected-exsearchincategories'] = w_isset_def( $searchData['selected-exsearchincategories'], array() );
			$searchData['selected-excludecategories']    = w_isset_def( $searchData['selected-excludecategories'], array() );

            /*
             * OLD SOLUTION, MIGHT BE BUGGY
             *
			if ( count( $searchData['selected-exsearchincategories'] ) > 0 ||
			     count( $searchData['selected-excludecategories'] ) > 0 ||
			     count( $options['categoryset'] ) > 0
			) {
				// If the category settings are invisible, ignore the excluded frontend categories, reset to empty array
				if ( $searchData['showsearchincategories'] == 0 ) {
					$searchData['selected-exsearchincategories'] = array();
				}

				$_all_cat    = get_terms( 'category', array( 'fields' => 'ids' ) );
				$_needed_cat = array_diff( $_all_cat, $searchData['selected-exsearchincategories'] );
				$_needed_cat = ! is_array( $_needed_cat ) ? array() : $_needed_cat;

				if ( $term_logic == 'and' ) {
					$exclude_categories = array_diff( array_merge( $_needed_cat, $searchData['selected-excludecategories'] ), $options['categoryset'] );
				} else {
					$exclude_categories = $options['categoryset'];
				}

				// If every category is selected, then we don't need to filter anything out.
				if ( count( $exclude_categories ) == count( $_all_cat ) ) {
					$exclude_categories = array();
				}
			}
            */

            // New solution
            if ( count( $searchData['selected-exsearchincategories'] ) > 0 ||
                count( $searchData['selected-excludecategories'] ) > 0 ||
                count( $options['categoryset'] ) > 0 ||
                $searchData['showsearchincategories'] == 1
            ) {

                // If the category settings are invisible, ignore the excluded frontend categories, reset to empty array
                if ( $searchData['showsearchincategories'] == 0 ) {
                    $searchData['selected-exsearchincategories'] = array();
                }

                $_all_cat    = get_terms( 'category', array( 'fields' => 'ids' ) );
                $_needed_cat = array_diff( $_all_cat, $searchData['selected-exsearchincategories'] );
                $_needed_cat = ! is_array( $_needed_cat ) ? array() : $_needed_cat;

                // I am pretty sure this is where the devil is born
                /*
                    AND -> Posts NOT in an array of term ids
                    OR  -> Posts in an array of term ids
                  */

                if ( $searchData['showsearchincategories'] == 1 ) // If the settings is visible, count for the options
                {
                    $exclude_categories = array_diff( array_merge( $_needed_cat, $searchData['selected-excludecategories'] ), $options['categoryset'] );
                } else // ..if the settings is not visible, then only the excluded categories count
                {
                    $exclude_categories = $searchData['selected-excludecategories'];
                }


            }

			$exclude_terms = array();

			if (w_isset_def($searchData['exclude_term_ids'], "") != "") {
				$exclude_terms = explode( ",", str_replace( array("\r", "\n"), '', $searchData['exclude_term_ids'] ) );
			}

			$all_terms = array_unique( array_merge( $exclude_categories, $exclude_terms ) );

			/**
			 *  New method
			 *
			 *  This is way more efficient, despite it looks more complicated.
			 *  Multiple sub-select is not an issue, since the query can use PRIMARY keys as indexes
			 */
			if ( count( $all_terms ) > 0 ) {
				$words = implode( ',', $all_terms );

				// Quick explanation for the AND
				// .. MAIN SELECT: selects all object_ids that are not in the array
				// .. SUBSELECT:   excludes all the object_ids that are part of the array
				// This is used because of multiple object_ids (posts in more than 1 category)
				if ( $term_logic == 'and' ) {
					if ( in_array(1, $all_terms) ) {
						$empty_term_query = "";
					} else {
						$empty_term_query = "
						NOT EXISTS (
							SELECT *
							FROM $wpdb->term_relationships as xt
							INNER JOIN $wpdb->term_taxonomy as tt ON ( xt.term_taxonomy_id = tt.term_taxonomy_id AND tt.taxonomy = 'category')
							WHERE
								xt.object_id = $wpdb->posts.ID
						) OR ";
					}

					$term_query = "(
						$empty_term_query

						$wpdb->posts.ID IN (
							SELECT DISTINCT(tr.object_id)
								FROM $wpdb->term_relationships AS tr
								WHERE
									tr.term_taxonomy_id NOT IN ($words)
									AND tr.object_id NOT IN (
										SELECT DISTINCT(trs.object_id)
										FROM $wpdb->term_relationships AS trs
										LEFT JOIN $wpdb->term_taxonomy as tts ON (trs.term_taxonomy_id = tts.term_taxonomy_id AND tts.taxonomy = 'category')
										WHERE trs.term_taxonomy_id IN ($words)
									)
						)
					)";
				} else {
					$term_query = "( $wpdb->posts.ID IN ( SELECT DISTINCT(tr.object_id) FROM wp_term_relationships AS tr WHERE tr.term_taxonomy_id IN ($words) ) )";
				}
			}


			/*------------ ttids in the main SELECT, we might not need it ---------*/
			// ttid is only used if grouping by category or filtering by category is active
			// LITE VERSION DOESNT NEED THESE
			// ---------------------------------------------------------------------


			/*------------------------ Exclude id's -------------------------*/
			if ( isset( $searchData['excludeposts'] ) && $searchData['excludeposts'] != "" ) {
				$exclude_posts = "($wpdb->posts.ID NOT IN (" . $searchData['excludeposts'] . "))";
			} else {
				$exclude_posts = "($wpdb->posts.ID NOT IN (-55))";
			}
			/*---------------------------------------------------------------*/

			/*------------------------ Term JOIN -------------------------*/
			// If the search in terms is not active, we don't need this unnecessary big join
			$term_join = "";
			if ( $options['searchinterms'] ) {
				$term_join = "
                LEFT JOIN $wpdb->term_relationships ON $wpdb->posts.ID = $wpdb->term_relationships.object_id
                LEFT JOIN $wpdb->term_taxonomy ON $wpdb->term_taxonomy.term_taxonomy_id = $wpdb->term_relationships.term_taxonomy_id
                LEFT JOIN $wpdb->terms ON $wpdb->term_taxonomy.term_id = $wpdb->terms.term_id";
			}
			/*---------------------------------------------------------------*/

			/*------------------------- Build like --------------------------*/
			$like_query = implode( ' OR ', $parts );
			if ( $like_query == "" ) {
				$like_query = "(1)";
			} else {
				$like_query = "($like_query)";
			}
			/*---------------------------------------------------------------*/

			/*---------------------- Build relevance ------------------------*/
			$relevance = implode( ' + ', $relevance_parts );
			if ( $relevance == "" ) {
				$relevance = "(1)";
			} else {
				$relevance = "($relevance)";
			}
			/*---------------------------------------------------------------*/


			/*------------------------- WPML filter -------------------------*/
            $wpml_query = "(1)";
            if ( isset( $options['wpml_lang'] )
                && w_isset_def( $searchData['wpml_compatibility'], 1 ) == 1
            ) {
                global $sitepress;
                $site_lang_selected = false;

                // Let us get the default site language if possible
                if ( is_object($sitepress) && method_exists($sitepress, 'get_default_language') ) {
                    $site_lang_selected = $sitepress->get_default_language() == $options['wpml_lang'] ? true : false;
                }

                $wpml_query = "
				EXISTS (
					SELECT DISTINCT(wpml.element_id)
					FROM " . $wpdb->base_prefix . "icl_translations as wpml
					WHERE
	                    $wpdb->posts.ID = wpml.element_id AND
	                    wpml.language_code = '" . $this->escape( $options['wpml_lang'] ) . "' AND
	                    wpml.element_type LIKE 'post_%'
                )";

                // For missing translations..
                // If the site language is used, the translation can be non-existent
                if ($site_lang_selected) {
                    $wpml_query = "
                    NOT EXISTS (
                        SELECT DISTINCT(wpml.element_id)
                        FROM " . $wpdb->base_prefix . "icl_translations as wpml
                        WHERE
                            $wpdb->posts.ID = wpml.element_id AND
                            wpml.element_type LIKE 'post_%'
                    ) OR
                    " . $wpml_query;
                }
            }
			/*---------------------------------------------------------------*/

			/*----------------------- POLYLANG filter -----------------------*/
			$polylang_query = "";
			if (isset( $options['polylang_lang'] ) &&
				$options['polylang_lang'] != "" &&
				$searchData['polylang_compatibility'] == 1
			) {
				$languages = get_terms('language', array(
								'hide_empty' => false,
								'fields' => 'ids',
								'orderby' => 'term_group',
								'slug' => $options['polylang_lang'])
				);
				if ( !empty($languages) && !is_wp_error($languages) && isset($languages[0]) ) {
					$polylang_query = " AND (
                    $wpdb->posts.ID IN ( SELECT DISTINCT(tr.object_id)
                        FROM $wpdb->term_relationships AS tr
                        LEFT JOIN $wpdb->term_taxonomy as tt ON (tr.term_taxonomy_id = tt.term_taxonomy_id AND tt.taxonomy = 'language')
                        WHERE tt.term_id = $languages[0]
			         ) )";
				}
			}
			/*---------------------------------------------------------------*/

            /*--------------------- Other Query stuff -----------------------*/
            // If the content is hidden, why select it..
            if ($searchData['showdescription'] == 0)
                $select_content = "''";
            else
                $select_content  = $wpdb->posts. ".post_content";

            // Dont select excerpt if its not used at all
            $select_excerpt = (
                w_isset_def($searchData['titlefield'], 0) == 1 ||
                w_isset_def($searchData['descriptionfield'], 0) == 1
            ) ? $wpdb->posts. ".post_excerpt" : "''";
            /*---------------------------------------------------------------*/

			$orderby  = ( ( isset( $searchData['selected-orderby'] ) && $searchData['selected-orderby'] != '' ) ? $searchData['selected-orderby'] : "post_date DESC" );
			$querystr = "
    		SELECT 
          $wpdb->posts.post_title as title,
          $wpdb->posts.ID as id,
          $wpdb->posts.post_date as date,               
          $select_content as content,
          $select_excerpt as excerpt,
          'pagepost' as content_type,
	        (SELECT
	            $wpdb->users.display_name as author
	            FROM $wpdb->users
	            WHERE $wpdb->users.ID = $wpdb->posts.post_author
	        ) as author,
          '' as ttid,
          $wpdb->posts.post_type as post_type,
          $relevance as relevance
    		FROM $wpdb->posts
        $postmeta_join
        $term_join
    	WHERE
                $post_types
            AND $post_statuses
            AND $term_query
            AND $like_query
            AND $exclude_posts
            AND ( $wpml_query )
            $polylang_query
        GROUP BY
          $wpdb->posts.ID
        ORDER BY
        	".$sd['orderby_primary'].", ".$sd['orderby_secondary'].", id DESC
        LIMIT " . $this->remaining_limit;

			$pageposts = $wpdb->get_results( $querystr, OBJECT );

            wd_asl()->debug->pushData(
                array(
                    "phrase"  =>  $s,
                    "options" =>  $options,
                    "query" =>    $querystr,
                    "results" =>  count($pageposts)
                ),
                "queries", false, true, false, 5
            );

			//var_dump($querystr);die("!!");
			//var_dump($pageposts);die("!!");

			$this->results = $pageposts;
			return $pageposts;
		}

		protected function post_process() {

			$pageposts  = is_array( $this->results ) ? $this->results : array();
			$options    = $this->options;
			$searchData = $this->searchData;
			$s          = $this->s;
			$_s         = $this->_s;

			// No post processing is needed on non-ajax search
			if ( isset($options['non_ajax_search']) ) {
				$this->results = $pageposts;
				return $pageposts;
			}

            $performance_options = get_option('asl_performance');

			if ( is_multisite() ) {
				$home_url = network_home_url();
			} else {
				$home_url = home_url();
			}

			foreach ( $pageposts as $k => $v ) {
				$r          = &$pageposts[ $k ];
				$r->title   = w_isset_def( $r->title, null );
				$r->content = w_isset_def( $r->content, null );
				$r->image   = w_isset_def( $r->image, null );
				$r->author  = w_isset_def( $r->author, null );
				$r->date    = w_isset_def( $r->date, null );
			}

			/* Images, title, desc */
			foreach ( $pageposts as $k => $v ) {

				// Let's simplify things
				$r = &$pageposts[ $k ];

				$r->title   = apply_filters( 'asl_result_title_before_prostproc', $r->title, $r->id );
				$r->content = apply_filters( 'asl_result_content_before_prostproc', $r->content, $r->id );
				$r->image   = apply_filters( 'asl_result_image_before_prostproc', $r->image, $r->id );
				$r->author  = apply_filters( 'asl_result_author_before_prostproc', $r->author, $r->id );
				$r->date    = apply_filters( 'asl_result_date_before_prostproc', $r->date, $r->id );

				$r->link = get_permalink( $v->id );

				$image_settings = $searchData['image_options'];


				if ( $image_settings['show_images'] != 0 ) {

					$im = $this->getBFIimage( $r );

					if ( $im != '' && strpos( $im, "mshots/v1" ) === false && w_isset_def($performance_options['image_cropping'], 0) == 1 ) {
						if ( w_isset_def( $image_settings['image_transparency'], 1 ) == 1 ) {
							$bfi_params = array( 'width'  => $image_settings['image_width'],
							                     'height' => $image_settings['image_height'],
							                     'crop'   => true
							);
						} else {
							$bfi_params = array( 'width'  => $image_settings['image_width'],
							                     'height' => $image_settings['image_height'],
							                     'crop'   => true,
							                     'color'  => wpnetbase_rgb2hex( $image_settings['image_bg_color'] )
							);
						}

						$r->image = bfi_thumb( $im, $bfi_params );
					} else {
						$r->image = $im;
					}
				}


				if ( ! isset( $searchData['titlefield'] ) || $searchData['titlefield'] == "0" || is_array( $searchData['titlefield'] ) ) {
					$r->title = get_the_title( $r->id );
				} else {
					if ( $searchData['titlefield'] == "1" ) {
						if ( strlen( $r->excerpt ) >= 200 ) {
							$r->title = wd_substr_at_word( $r->excerpt, 200 );
						} else {
							$r->title = $r->excerpt;
						}
					} else {
						$mykey_values = get_post_custom_values( $searchData['titlefield'], $r->id );
						if ( isset( $mykey_values[0] ) ) {
							$r->title = $mykey_values[0];
						} else {
							$r->title = get_the_title( $r->id );
						}
					}
				}

				if ( ! isset( $searchData['striptagsexclude'] ) ) {
					$searchData['striptagsexclude'] = "<a><span>";
				}

				if ( ! isset( $searchData['descriptionfield'] ) || $searchData['descriptionfield'] == "0" || is_array( $searchData['descriptionfield'] ) ) {
					if ( function_exists( 'qtrans_getLanguage' ) ) {
						$r->content = apply_filters( 'the_content', $r->content );
					}
					$_content = strip_tags($r->content);
				} else {
					if ( $searchData['descriptionfield'] == "1" ) {
						$_content = strip_tags( $r->excerpt );
					} else if ( $searchData['descriptionfield'] == "2" ) {
						$_content = strip_tags( get_the_title( $r->id ) );
					} else {
						$mykey_values = get_post_custom_values( $searchData['descriptionfield'], $r->id );
						if ( isset( $mykey_values[0] ) ) {
							$_content = strip_tags( $mykey_values[0] );
						} else {
							$_content = strip_tags( $r->content );
						}
					}
				}
				if ( $_content == "" && $r->content != '') {
					$_content = $r->content;
				}

				// Deal with the shortcodes here, for more accuracy
				if ( $searchData['shortcode_op'] == "remove" ) {
					if ( $_content != "" ) {
						// Remove shortcodes, keep the content, really fast and effective method
						$_content = preg_replace("~(?:\[/?)[^\]]+/?\]~su", '', $_content);
					}
				} else {
					if ( $_content != "" ) {
						$_content = apply_filters( 'the_content', $_content, $searchId );
					}
				}

				// Remove styles and scripts
				$_content = preg_replace( array(
					'#<script(.*?)>(.*?)</script>#is',
					'#<style(.*?)>(.*?)</style>#is'
				), '', $_content );

				$_content = strip_tags( $_content );

                // Get the words from around the search phrase, or just the description
                if ( w_isset_def($searchData['description_context'], 1) == 1 && count( $_s ) > 0 )
                    $_content = $this->context_find( $_content, $_s[0], floor($searchData['descriptionlength'] / 6), $searchData['descriptionlength'] );
                else if ( $_content != '' && ( strlen( $_content ) > $searchData['descriptionlength'] ) )
                    $_content = wd_substr_at_word( $_content, $searchData['descriptionlength'] ) . "...";

				$_content   = wd_closetags( $_content );
				$r->content = $_content;

				// -------------------------- Woocommerce Fixes -----------------------------
				// A trick to fix the url
				if ( $r->post_type == 'product_variation' &&
				     class_exists( 'WC_Product_Variation' )
				) {
					$r->title = preg_replace( "/(Variation) \#(\d+) (of)/si", '', $r->title );
					$wc_prod_var_o = new WC_Product_Variation( $r->id );
					$r->link       = $wc_prod_var_o->get_permalink();
				}
				// --------------------------------------------------------------------------

				$r->title   = apply_filters( 'asl_result_title_after_prostproc', $r->title, $r->id );
				$r->content = apply_filters( 'asl_result_content_after_prostproc', $r->content, $r->id );
				$r->image   = apply_filters( 'asl_result_image_after_prostproc', $r->image, $r->id );
				$r->author  = apply_filters( 'asl_result_author_after_prostproc', $r->author, $r->id );
				$r->date    = apply_filters( 'asl_result_date_after_prostproc', $r->date, $r->id );

			}
			/* !Images, title, desc */
			//var_dump($pageposts); die();
			$this->results = $pageposts;

			return $pageposts;

		}

		protected function group() {
			return $this->results;
		}

		/**
		 * Fetches an image for BFI class
		 */
		function getBFIimage( $post ) {
            $searchData = $this->searchData;

			if ( ! isset( $post->image ) || $post->image == null ) {
				$home_url = network_home_url();
				$home_url = home_url();

				if ( ! isset( $post->id ) ) {
					return "";
				}
				$i  = 1;
				$im = "";
				for ( $i == 1; $i < 6; $i ++ ) {
					switch ( $this->imageSettings[ 'image_source' . $i ] ) {
						case "featured":
							$im = wp_get_attachment_url( get_post_thumbnail_id( $post->id ) );
							if ( is_multisite() ) {
								$im = str_replace( home_url(), network_home_url(), $im );
							}
							break;
						case "content":
                            if ($searchData['showdescription'] == 0)
                                $content = get_post_field('post_content', $post->id);
                            else
                                $content = $post->content;
                            $content = apply_filters('the_content', $content);

							$im = wpnetbase_get_image_from_content( $content, 1 );
							if ( is_multisite() ) {
								$im = str_replace( home_url(), network_home_url(), $im );
							}
							break;
						case "excerpt":
							$im = wpnetbase_get_image_from_content( $post->excerpt, 1 );
							if ( is_multisite() ) {
								$im = str_replace( home_url(), network_home_url(), $im );
							}
							break;
						case "screenshot":
							$im = 'http://s.wordpress.com/mshots/v1/' . urlencode( get_permalink( $post->id ) ) .
							      '?w=' . $this->imageSettings['image_width'] . '&h=' . $this->imageSettings['image_height'];
							break;
						case "custom":
							if ( $this->imageSettings['image_custom_field'] != "" ) {
								$val = get_post_meta( $post->id, $this->imageSettings['image_custom_field'], true );
								if ( $val != null && $val != "" ) {
									$im = $val;
								}
							}
							break;
						case "default":
							if ( $this->imageSettings['image_default'] != "" ) {
								$im = $this->imageSettings['image_default'];
							}
							break;
						default:
							$im = "";
							break;
					}
					if ( $im != null && $im != '' ) {
						break;
					}
				}

				return $im;
			} else {
				return $post->image;
			}
		}

		/**
		 * Returns the context of a phrase within a text (max 1800 characters).
		 * Uses preg_split method to iterate through strings.
		 *
		 * @param $str string context
		 * @param $needle string context
		 * @param $context int length of the context
		 * @param $maxlength int maximum length of the string in characters
		 * @return string
		 */
		function context_find($str, $needle, $context, $maxlength) {
			$haystack = ' '.trim($str).' ';

			// To prevent memory overflow, we need to limit the hay to relatively low count
			$haystack = wd_substr_at_word(ASL_mb::strtolower($haystack), 1800);
			$needle = ASL_mb::strtolower($needle);

			if ( $needle == "" ) return $str;

			/**
			 * This is an interesting issue. Turns out mb_substr($hay, $start, 1) is very ineffective.
			 * the preg_split(..) method is far more efficient in terms of speed, however it needs much more
			 * memory. In our case speed is the top priority. However to prevent memory overflow, the haystack
			 * is reduced to 1800 characters (roughly 300 words) first.
			 *
			 * Reference ticket: https://wp-dreams.com/forums/topic/search-speed/
			 * Speed tests: http://stackoverflow.com/questions/3666306/how-to-iterate-utf-8-string-in-php
			 */
			$chrArray = preg_split('//u', $haystack, -1, PREG_SPLIT_NO_EMPTY);
			$hay_length = count($chrArray) - 1;

			if ( $i = ASL_mb::strpos($haystack, $needle) ) {
				$start=$i;
				$end=$i;
				$spaces=0;

				while ($spaces < ((int) $context/2) && $start > 0) {
					$start--;
					if ($chrArray[$start] == ' ') {
						$spaces++;
					}
				}

				while ($spaces < ($context +1) && $end < $hay_length) {
					$end++;
					if ($chrArray[$end] == ' ') {
						$spaces++;
					}
				}

				while ($spaces < ($context +1) && $start > 0) {
					$start--;
					if ($chrArray[$start] == ' ') {
						$spaces++;
					}
				}

				$str_start = ($start - 1) < 0 ? 0 : ($start -1);
				$str_end = ($end - 1) < 0 ? 0 : ($end -1);

				$result = trim(ASL_mb::substr($str, $str_start, ($str_end - $str_start)));

				// Somewhere inbetween..
				if ( $start != 0 && $end < $hay_length )
					return "..." . $result . "...";

				// Beginning
				if ( $start == 0 && $end < $hay_length )
					return $result . "...";

				// End
				if ( $start != 0 && $end == $hay_length )
					return "..." . $result;

				// If it is too long, strip it
				if ( ASL_mb::strlen($result) > $maxlength)
					return wd_substr_at_word( $result, $maxlength ) . "...";

				// Else, it is the whole
				return $result;

			} else {
				// If it is too long, strip it
				if ( ASL_mb::strlen($str) > $maxlength)
					return wd_substr_at_word( $str, $maxlength ) . "...";

				return $str;
			}
		}

		/**
		 * An empty function to override individual shortcodes, this must be public
		 *
		 * @return string
		 */
		public function return_empty_string() {
			return "";
		}

	}
}
?>