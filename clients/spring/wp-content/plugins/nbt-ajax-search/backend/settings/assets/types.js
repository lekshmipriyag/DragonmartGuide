// Javascript For the types
jQuery(function($){
    // ------------------------- GENERICS ------------------------

    /**
     * Simple select
     */
    $('.wpnetbaseSelect .wpnetbaseselect').change(function () {
        _self.hidden = $(this).next();
        var selhidden = $(this).next().next();
        var val = $(_self.hidden).val().match(/(.*[\S\s]*?)\|\|(.*)/);
        var options = val[1];
        var selected = val[2];
        $(_self.hidden).val(options + "||" + $(this).val());
        selhidden.val($(this).val());
    });
    $('.wpnetbaseSelect .triggerer').bind('click', function () {
        var parent = $(this).parent();
        var select = $('select', parent);
        var hidden = select.next();
        var selhidden = hidden.next();
        var val = $(hidden).val().replace(/(\r\n|\n|\r)/gm, "").match(/(.*[\S\s]*?)\|\|(.*)/);
        var selected = $.trim(val[2]);
        select.val(selected);
        selhidden.val(selected);
    });

    /**
     * Textarea as parameter
     */
    $('.wpnetbaseTextareaIsParam .triggerer').bind('click', function () {
        $('textarea', $(this).parent()).change();
    });

    /**
     * OnOff button
     */
    $('.wpnetbaseOnOff .wpnetbaseOnOffInner').on('click', function () {
        var hidden = $(this).prev();
        var val = $(hidden).val();
        if (val == 1) {
            val = 0;
            $(this).parent().removeClass("active");
        } else {
            val = 1;
            $(this).parent().addClass("active");
        }
        $(hidden).val(val);
        $(hidden).change();
    });
    $('.wpnetbaseOnOff .triggerer').on('click', function () {
        var hidden = $('input[type=hidden]', $(this).parent());
        var div = $(this).parent();
        var val = $(hidden).val();
        if (val == 0) {
            div.removeClass("active");
        } else {
            div.addClass("active");
        }
    });

    /**
     * YesNo button
     */
    $('.wpnetbaseYesNo .wpnetbaseYesNoInner').on('click', function () {
        var hidden = $(this).prev();
        var val = $(hidden).val();
        if (val == 1) {
            val = 0;
            $(this).parent().removeClass("active");
        } else {
            val = 1;
            $(this).parent().addClass("active");
        }
        $(hidden).val(val);
        $(hidden).change();
    });
    $('.wpnetbaseYesNo .triggerer').on('click', function () {
        var hidden = $('input[type=hidden]', $(this).parent());
        var div = $(this).parent();
        var val = $(hidden).val();
        if (val == 0) {
            div.removeClass("active");
        } else {
            div.addClass("active");
        }
        $(hidden).change();
    });

    /**
     * Up-down arrow
     */
    $('.wpnetbase-updown .wpnetbase-uparrow').click(function () {
        var prev = $(this).parent().prev();
        while (!prev.is('input')) {
            prev = prev.prev();
        }
        prev.val(parseFloat($(prev).val()) + 1);
        prev.change();
    });
    $('.wpnetbase-updown .wpnetbase-downarrow').click(function () {
        var prev = $(this).parent().prev();
        while (!prev.is('input')) {
            prev = prev.prev();
        }
        prev.val(parseFloat($(prev).val()) - 1);
        prev.change();
    });

    /**
     * 4 value storage (padding, margin etc..)
     */
    $('.wpnetbaseFour input[type=text]').change(function () {
        var value = "";
        $('input[type=text]', $(this).parent()).each(function () {
            value += $(this).val() + "||";
        });
        $('input[isparam=1]', $(this).parent()).val("||" + value);
        $('input[isparam=1]', $(this).parent()).change();
    });
    $('.wpnetbaseFour>fieldset>.triggerer').bind('click', function () {
        var hidden = $("input[isparam=1]", $(this).parent());
        var values = hidden.val().match(/\|\|(.*?)\|\|(.*?)\|\|(.*?)\|\|(.*?)\|\|/);
        var i = 1;
        $('input[type=text]', $(this).parent()).each(function () {
            if ($(this).attr('name') != null) {
                $(this).val(values[i]);
                i++;
            }
        });
        hidden.change();
    });

    /**
     * DatePicker
     */
    $('.wpnetbaseDatePicker input').datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true
    });

    // --------------------- COMPLEX TYPES -----------------------
    /**
     * Array-chained select
     */
    $('.wpnetbaseCustomArraySelect select').change(function () {
        var $hidden = $('input[isparam=1]', $(this).parent());
        var valArr = [];

        $('select', $(this).parent()).each(function(index){
            valArr.push( $(this).val() );
        });

        $hidden.val( valArr.join('||') );
    });


    /**
     * Category selector
     */
    $('div.wpnetbaseCategories').each(function(){
        var id = $(this).attr('id').match(/^wpnetbaseCategories-(.*)/)[1];
        var selector = "#sortable" + id +", #sortable_conn" + id;
        var name = $('input[isparam=1]', this).attr('name');

        $(selector).sortable({
            connectWith: ".connectedSortable"
        }, {
            update: function (event, ui) {

            }
        }).disableSelection();
        $(selector).on('sortupdate', function(event, ui) {
            if (typeof(ui)!='undefined')
                var parent = $(ui.item).parent();
            else
                var parent = $(event.target);
            while (!parent.hasClass('wpnetbaseCategories')) {
                parent = $(parent).parent();
            }
            var items = $('ul[id*=sortable_conn] li', parent);
            var hidden = $('input[name=' + name + ']', parent);
            var val = "";
            items.each(function () {
                val += "|" + $(this).attr('bid');
            });
            val = val.substring(1);
            hidden.val(val);
        });
        $("#sortablecontainer" + id + " .arrow-all-left").click(function(){
            $("#sortable_conn" + id + " li")
                .detach().appendTo("#sortable" + id + "");
            $(selector).trigger("sortupdate");
        });
        $("#sortablecontainer" + id + " .arrow-all-right").click(function(){
            $("#sortable" + id + " li:not(.hiddend)")
                .detach().appendTo("#sortable_conn" + id);
            $(selector).trigger("sortupdate");
        });
    });

    $('div.wpnetbaseSortable').each(function(){
        var id = $(this).attr('id').match(/^wpnetbaseSortable-(.*)/)[1];
        var selector = "#sortable" + id +", #sortable_conn" + id;
        var name = $('input[isparam=1]', this).attr('name');

        $(selector).sortable({

        }, {
            update: function (event, ui) {
                var parent = $(ui.item).parent();
                while (!parent.hasClass('wpnetbaseSortable')) {
                    parent = $(parent).parent();
                }
                var items = $('ul[id*=sortable] li', parent);
                var hidden = $('input[name=' + name + ']', parent);
                var val = "";
                items.each(function () {
                    val += "|" + $(this).html();
                });
                val = val.substring(1);
                hidden.val(val);
            }
        }).disableSelection();
    });

    $('div.wpnetbaseTaxonomySelect').each(function(){
        var id = $(this).attr('id').match(/^wpnetbaseTaxonomySelect-(.*)/)[1];
        var selector = "#sortable" + id +", #sortable_conn" + id;
        var name = $('input[isparam=1]', this).attr('name');

        $(selector).sortable({
            connectWith: ".connectedSortable"
        }, {
            update: function (event, ui) {
            }
        }).disableSelection();
        $(selector).on('sortupdate', function(event, ui) {
            if (typeof(ui)!='undefined')
                var parent = $(ui.item).parent();
            else
                var parent = $(event.target);
            while (!parent.hasClass('wpnetbaseTaxonomySelect')) {
                parent = $(parent).parent();
            }
            var items = $('ul[id*=sortable_conn] li', parent);
            var hidden = $('input[name=' + name + ']', parent);
            var val = "";
            items.each(function () {
                val += "|" + $(this).attr('taxonomy');
            });
            val = val.substring(1);
            hidden.val(val);
        });
        $("#sortablecontainer" + id + " .arrow-all-left").click(function(){
            $("#sortable_conn" + id + " li")
                .detach().appendTo("#sortable" + id + "");
            $(selector).trigger("sortupdate");
        });
        $("#sortablecontainer" + id + " .arrow-all-right").click(function(){
            $("#sortable" + id + " li:not(.hiddend)")
                .detach().appendTo("#sortable_conn" + id);
            $(selector).trigger("sortupdate");
        });
    });

    /**
     * Date interval selector
     */
    $('div.wd_DateInterval').each(function() {
        var hidden = $('input[isparam=1]', this);
        var val = hidden.val();

        var $this = $(this);
        var o = {
            "mode": $("select.wd_di_mode", $this),
            "from": $("select.wd_di_from", $this),
            "to": $("select.wd_di_to", $this),
            "fromDate": $("input.wd_di_fromDate", $this),
            "toDate": $("input.wd_di_toDate", $this),
            "fromyy": $("input.wd_di_fromyy", $this),
            "frommm": $("input.wd_di_frommm", $this),
            "fromdd": $("input.wd_di_fromdd", $this),
            "toyy": $("input.wd_di_toyy", $this),
            "tomm": $("input.wd_di_tomm", $this),
            "todd": $("input.wd_di_todd", $this)
        }

        function showHideOptions() {
            if (o.from.val() == "date") {
                $(".wd_di_fromreld", $this).addClass("hiddend");
                o.fromDate.removeClass("hiddend");
            } else if (o.from.val() == "rel_date") {
                $(".wd_di_fromreld", $this).removeClass("hiddend");
                o.fromDate.addClass("hiddend");
            } else {
                $(".wd_di_fromreld", $this).add(o.fromDate).addClass("hiddend");
            }

            if (o.to.val() == "date") {
                $(".wd_di_toreld", $this).addClass("hiddend");
                o.toDate.removeClass("hiddend");
            } else if (o.to.val() == "rel_date") {
                $(".wd_di_toreld", $this).removeClass("hiddend");
                o.toDate.addClass("hiddend");
            } else {
                $(".wd_di_toreld", $this).add(o.toDate).addClass("hiddend");
            }
        }

        function init() {
            var vals = val.split("|");
            var from = vals[5].split(",");
            var to = vals[6].split(",");

            o.mode.val(vals[0]);
            o.from.val(vals[1]);
            o.to.val(vals[2]);
            o.fromDate.val(vals[3]);
            o.toDate.val(vals[4]);

            o.fromyy.val(from[0]);
            o.frommm.val(from[1]);
            o.fromdd.val(from[2]);

            o.toyy.val(to[0]);
            o.tomm.val(to[1]);
            o.todd.val(to[2]);

            o.fromDate.datepicker({
                dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true,
                onSelect: parseParams
            });
            o.toDate.datepicker({
                dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true,
                onSelect: parseParams
            });
            showHideOptions();
        }

        function parseParams() {
            var res = o.mode.val() + "|" + o.from.val() + "|" + o.to.val();
            res += "|" + o.fromDate.val() + "|" + o.toDate.val();

            res += "|" + ( o.fromyy.val() == "" ? 0 : o.fromyy.val() );
            res += "," + ( o.frommm.val() == "" ? 0 : o.frommm.val() );
            res += "," + ( o.fromdd.val() == "" ? 0 : o.fromdd.val() );

            res += "|" + ( o.toyy.val() == "" ? 0 : o.toyy.val() );
            res += "," + ( o.tomm.val() == "" ? 0 : o.tomm.val() );
            res += "," + ( o.todd.val() == "" ? 0 : o.todd.val() );

            hidden.val(res);
            showHideOptions();
        }

        init();

        $("input", $this).on("keyup", function(){
           parseParams();
        });
        $("select", $this).on("change", function(){
            parseParams();
        });
    });

    /**
     * Date interval selector
     */
    $('div.wd_DateFilter').each(function() {
        var hidden = $('input[isparam=1]', this);
        var val = hidden.val();

        var $this = $(this);
        var o = {
            "state": $("select.wd_di_state", $this),
            "date": $("input.wd_di_date", $this),
            "yy": $("input.wd_di_yy", $this),
            "mm": $("input.wd_di_mm", $this),
            "dd": $("input.wd_di_dd", $this)
        }

        function showHideOptions() {
            if (o.state.val() == "date") {
                $(".wd_di_rel_date", $this).addClass("hiddend");
                o.date.removeClass("hiddend");
            } else if (o.state.val() == "rel_date") {
                $(".wd_di_rel_date", $this).removeClass("hiddend");
                o.date.addClass("hiddend");
            } else {
                $(".wd_di_rel_date", $this).add(o.date).addClass("hiddend");
            }
        }

        function init() {
            var vals = val.split("|");
            var rel_date = vals[2].split(",");

            o.state.val(vals[0]);
            o.date.val(vals[1]);

            o.yy.val(rel_date[0]);
            o.mm.val(rel_date[1]);
            o.dd.val(rel_date[2]);

            o.date.datepicker({
                dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true,
                onSelect: parseParams
            });
            showHideOptions();
        }

        function parseParams() {
            var res = o.state.val() + "|" + o.date.val();

            res += "|" + ( o.yy.val() == "" ? 0 : o.yy.val() );
            res += "," + ( o.mm.val() == "" ? 0 : o.mm.val() );
            res += "," + ( o.dd.val() == "" ? 0 : o.dd.val() );

            hidden.val(res);
            showHideOptions();
        }

        init();

        $("input", $this).on("keyup", function(){
            parseParams();
        });
        $("select", $this).on("change", function(){
            parseParams();
        });
    });

    /**
     * Tag search and select
     */
    $('div.wpnetbaseSearchTags').each(function() {

        function parseParams( $el ) {
            var tags = [];

            $(".wd_tagSelectContent .wd_tag", $el).each(function(){
                tags.push($(this).attr("tagid"));
            });

            return tags.join("|");
        }

        function refreshResults( $el ) {
            $(".wd_tagSearchResults:not(.hiddend) p span", $el).each(function() {
                if ( $(".wd_tagSelectContent:not(.hiddend) span.wd_tag[tagid=" + $(this).attr("termid") + "]", $this).length == 0 ) {
                    $(this).addClass("not_listed_yo");
                } else {
                    $(this).removeClass("not_listed_yo");
                }
            });
        }

        var hidden = $('input[isparam=1]', this);
        var $this = $(this);

        var t = null;
        var post = null;
        $(".wd_tagSelSearch input", $this).on("keyup", function(){
            var phrase = $(this).val();
            var $inp = $(this);
            var $loader = $(".loading-small", $inp.parent());
            var $x = $(".wd_ts_close", $inp.parent());

            clearTimeout(t);
            if (post != null)
                post.abort();

            if (phrase == "") {
                $loader.addClass('hiddend');
                $(".wd_tagSelSearch .wd_ts_close", $this).click();
                return;
            }

            t = setTimeout(function(){
                $loader.removeClass('hiddend');
                $x.removeClass('hiddend');
                var data = {
                    'action': 'wd_search_tags',
                    'wd_tag_phrase': phrase,
                    'wd_required': 1
                };
                post = $.post(ajaxurl, data, function(response) {
                    response = response.replace(/^\s*[\r\n]/gm, "");
                    response = response.match(/!!WDSTART!!(.*[\s\S]*)!!WDEND!!/)[1];

                    if (response != "") {
                        $(".wd_tagSearchResults:not(.hiddend)", $this).html(response);
                    }

                    refreshResults($this);

                    $loader.addClass('hiddend');
                }, 'text');
            }, 150);
        });

        $(".wd_tagSelSearch .wd_ts_close", $this).on("click", function(){
            if (post != null)
                post.abort();
            $(".wd_tagSelSearch input", $this).val("");
            $(".wd_tagSearchResults:not(.hiddend)", $this).html("");
            $(".wd_ts_close", $this).addClass('hiddend');
            $(".loading-small", $this).addClass('hiddend');
        });

        $(".wd_tagSearchResults:not(.hiddend)", $this).on("click", "span.not_listed_yo", function() {

            $("<span class='wd_tag' tagid='" + $(this).attr("termid") + "'><a class='wd_tag_remove'></a>" + $(this).parent().text().replace(">>ADD", "") + "</span>")
                .appendTo( $(".wd_tagSelectContent:not(.hiddend)", $this) );

            //check exists
            refreshResults($this);
            hidden.val(parseParams($this));
        });

        /* Tag remove */
        $(".wd_tagSelectContent", $this).on("click", "span.wd_tag a", function() {
            if ( $(this).hasClass("wd_tag_remove") ) {
                // In case of clicking the remove item

                $(this).parent().remove();
                refreshResults($this);
            }
            hidden.val(parseParams($this));
        });
    });

    /**
     * Tag selector
     */
    $('div.wpnetbaseSelectTags').each(function(){

        function parseParams( $el ) {
            var active = $(".wpnetbaseYesNoSt", $el).hasClass("active") ? 1 : 0;
            var source = $(".wd_tagSelectSource", $el).val();
            var dmode = $(".wd_tagDisplayMode", $el).val();
            var tags = [];
            var selTags = [];
            var defTag = "";

            var allStatus = $("select.wd_tagAllStatus", $el).val();

            $(".wd_tagSelectContent.ts_selected .wd_tag", $el).each(function(){
                tags.push($(this).attr("tagid"));
                if ( $("a.wd_tag_checked", $(this)).length > 0 )
                    selTags.push($(this).attr("tagid"));
            });
            $(".wd_tagSelectContent.ts_all .wd_tag", $el).each(function(){
                defTag = $(this).attr("tagid");
            });

            return active + "|" + dmode + "|" + source+ "|" + allStatus + "|" + tags.join(",") + "|" + selTags.join(",") + "|" + defTag;
        }

        function showHideStuff( $el ) {
            var vals = hidden.val().split("|");
            $(".showif_c", $el).each(function(){
                var rules = $(this).attr("showif").split("|");
                for (var i=0;i<rules.length;i++) {
                    if ( (rules[i].indexOf(vals[1]) > -1) && (rules[i].indexOf(vals[2]) > -1) ) {
                        $(this).removeClass("hiddend");
                        break;
                    } else {
                        $(this).addClass("hiddend");
                    }
                }
            });
        }

        function refreshResults( $el ) {
            $(".wd_tagSearchResults:not(.hiddend) p span", $el).each(function() {
                if ( $(".wd_tagSelectContent:not(.hiddend) span.wd_tag[tagid=" + $(this).attr("termid") + "]", $this).length == 0 ) {
                    $(this).addClass("not_listed_yo");
                } else {
                    $(this).removeClass("not_listed_yo");
                }
            });
        }

        var $this = $(this);
        var id = $(this).attr('id').match(/^wpnetbaseSelectTags-(.*)/)[1];
        //var selector = "#sortable" + id +", #sortable_conn" + id;
        var hidden = $('input[isparam=1]', this);

        $(".wd_tagSelectContent", $this).sortable({
            items: ".wd_tag",
            update: function( event, ui ) {
                hidden.val(parseParams($this));
            }
        });

        $(".wpnetbaseYesNoSt", $this).on("click", function(){
            $(this).toggleClass("active");
            hidden.val(parseParams($this));
            showHideStuff();
        });
        $(".wd_tagSelectSource", $this).on("change", function(){
            hidden.val(parseParams($this));
            showHideStuff();
            refreshResults($this);
        });
        $(".wd_tagDisplayMode", $this).on("change", function(){
            hidden.val(parseParams($this));
            showHideStuff();
            refreshResults($this);
        });

        $("select.wd_tagAllStatus", $this).on("change", function(){
            hidden.val(parseParams($this));
            showHideStuff();
            refreshResults($this);
        });

        var t = null;
        var post = null;
        $(".wd_tagSelSearch input", $this).on("keyup", function(){
            var phrase = $(this).val();
            var $inp = $(this);
            var $loader = $(".loading-small", $inp.parent());
            var $x = $(".wd_ts_close", $inp.parent());

            clearTimeout(t);
            if (post != null)
                post.abort();

            if (phrase == "") {
                $loader.addClass('hiddend');
                $(".wd_tagSelSearch .wd_ts_close", $this).click();
                return;
            }

            t = setTimeout(function(){
                $loader.removeClass('hiddend');
                $x.removeClass('hiddend');
                var data = {
                    'action': 'wd_search_tag',
                    'wd_tag_phrase': phrase,
                    'wd_required': 1
                };
                post = $.post(ajaxurl, data, function(response) {
                    response = response.replace(/^\s*[\r\n]/gm, "");
                    response = response.match(/!!WDSTART!!(.*[\s\S]*)!!WDEND!!/)[1];

                    if (response != "") {
                        $(".wd_tagSearchResults:not(.hiddend)", $this).html(response);
                    }

                    refreshResults($this);

                    $loader.addClass('hiddend');
                }, 'text');
            }, 150);
        });

        $(".wd_tagSelSearch .wd_ts_close", $this).on("click", function(){
            if (post != null)
                post.abort();
            $(".wd_tagSelSearch input", $this).val("");
            $(".wd_tagSearchResults:not(.hiddend)", $this).html("");
            $(".wd_ts_close", $this).addClass('hiddend');
            $(".loading-small", $this).addClass('hiddend');
        });

        $(".wd_tagSearchResults:not(.hiddend)", $this).on("click", "span.not_listed_yo", function() {
            var oneTagOnly = $(".wd_tagSelectContent:not(.hiddend)", $this).hasClass("ts_all");

            if ( oneTagOnly ) {
                $(".wd_tagSelectContent:not(.hiddend)", $this).html(
                    ("<span class='wd_tag' tagid='" + $(this).attr("termid") + "'><a class='wd_tag_remove'></a>" + $(this).parent().text().replace(">>USE", "") + "</span>")
                );
            } else {
                $("<span class='wd_tag' tagid='" + $(this).attr("termid") + "'><a class='wd_tag_remove'></a><a class='wd_tag_checked'></a>" + $(this).parent().text().replace(">>USE", "") + "</span>")
                    .appendTo( $(".wd_tagSelectContent:not(.hiddend)", $this) );
            }

            //check exists
            refreshResults($this);
            hidden.val(parseParams($this));
        });

        /* Tag remove */
        $(".wd_tagSelectContent", $this).on("click", "span.wd_tag a", function() {
            if ( $(this).hasClass("wd_tag_remove") ) {
                // In case of clicking the remove item

                $(this).parent().remove();
                refreshResults($this);
            } else {
                // In case if clicking the tick

                if ( $(this).hasClass("wd_tag_checked") ) {
                    $(this).removeClass("wd_tag_checked");
                    $(this).addClass("wd_tag_unchecked")
                } else {
                    $(this).addClass("wd_tag_checked");
                    $(this).removeClass("wd_tag_unchecked")
                }
            }

            hidden.val(parseParams($this));
        });
    });


    /**
     * BuddyPress XProfile fields selector
     */
    $('div.wpnetbaseBP_XProfileFields').each(function(){
        var id = $(this).attr('id').match(/^wpnetbaseBP_XProfileFields-(.*)/)[1];
        var selector = "#sortable" + id +", #sortable_conn" + id;
        var name = $('input[isparam=1]', this).attr('name');

        $(selector).sortable({
            connectWith: ".connectedSortable"
        }, {
            update: function (event, ui) {

            }
        }).disableSelection();
        $(selector).on('sortupdate', function(event, ui) {
            if (typeof(ui)!='undefined')
                var parent = $(ui.item).parent();
            else
                var parent = $(event.target);
            while (!parent.hasClass('wpnetbaseBP_XProfileFields')) {
                parent = $(parent).parent();
            }
            var items = $('ul[id*=sortable_conn] li', parent);
            var hidden = $('input[name=' + name + ']', parent);
            var val = "";
            items.each(function () {
                val += "|" + $(this).attr('bid');
            });
            val = val.substring(1);
            hidden.val(val);
        });
        $("#sortablecontainer" + id + " .arrow-all-left").click(function(){
            $("#sortable_conn" + id + " li")
                .detach().appendTo("#sortable" + id + "");
            $(selector).trigger("sortupdate");
        });
        $("#sortablecontainer" + id + " .arrow-all-right").click(function(){
            $("#sortable" + id + " li:not(.hiddend)")
                .detach().appendTo("#sortable_conn" + id);
            $(selector).trigger("sortupdate");
        });
    });

    /**
     * Draggable selector
     */
    $('div.wpnetbaseDraggable').each(function(){
        var id = $(this).attr('id').match(/^wpnetbaseDraggable-(.*)/)[1];
        var selector = "#sortable" + id +", #sortable_conn" + id;
        var name = $('input[isparam=1]', this).attr('name');

        $(selector).sortable({
            connectWith: ".connectedSortable"
        }, {
            update: function (event, ui) {
            }
        }).disableSelection();

        $(selector).on('sortupdate', function(event, ui) {
            if (typeof(ui)!='undefined')
                var parent = $(ui.item).parent();
            else
                var parent = $(event.target);
            while (!parent.hasClass('wpnetbaseDraggable')) {
                parent = $(parent).parent();
            }
            var items = $('ul[id*=sortable_conn] li', parent);
            var hidden = $('input[name=' + name + ']', parent);
            var val = "";
            items.each(function () {
                val += "|" + $(this).attr('key');
            });
            val = val.substring(1);
            hidden.val(val);
        });
    });

    /**
     * User role select
     */
    $('div.wpnetbaseUserRoleSelect').each(function(){
        var id = $(this).attr('id').match(/^wpnetbaseUserRoleSelect-(.*)/)[1];
        var selector = "#sortable" + id +", #sortable_conn" + id;
        var name = $('input[isparam=1]', this).attr('name');

        $(selector).sortable({
            connectWith: ".connectedSortable"
        }, {
            update: function (event, ui) {
            }
        }).disableSelection();

        $(selector).on('sortupdate', function(event, ui) {
            if (typeof(ui)!='undefined')
                var parent = $(ui.item).parent();
            else
                var parent = $(event.target);
            while (!parent.hasClass('wpnetbaseUserRoleSelect')) {
                parent = $(parent).parent();
            }
            var items = $('ul[id*=sortable_conn] li', parent);
            var hidden = $('input[name=' +name + ']', parent);
            var val = "";
            items.each(function () {
                val += "|" + $(this).html();
            });
            val = val.substring(1);
            hidden.val(val);
        });

        $("#sortablecontainer" + id + " .arrow-all-left").click(function(){
            $("#sortable_conn" + id + " li")
                .detach().appendTo("#sortable" + id + "");
            $(selector).trigger("sortupdate");
        });
        $("#sortablecontainer" + id + " .arrow-all-right").click(function(){
            $("#sortable" + id)
                .detach().appendTo("#sortable_conn" + id);
            $(selector).trigger("sortupdate");
        });
    });

    /**
     * Custom Post types
     */
    $('div.wpnetbaseCustomPostTypes').each(function(){
        var id = $(this).attr('id').match(/^wpnetbaseCustomPostTypes-(.*)/)[1];
        var selector = "#sortable" + id +", #sortable_conn" + id;
        var name = $('input[isparam=1]', this).attr('name');

        $(selector).sortable({
            connectWith: ".connectedSortable"
        }, {
            update: function (event, ui) {

            }
        }).disableSelection();
        $(selector).on('sortupdate', function(event, ui) {
            if (typeof(ui)!='undefined')
                var parent = $(ui.item).parent();
            else
                var parent = $(event.target);
            while (!parent.hasClass('wpnetbaseCustomPostTypes')) {
                parent = $(parent).parent();
            }
            var items = $('ul[id*=sortable_conn] li', parent);
            var hidden = $('input[name=' + name + ']', parent);
            var val = "";
            items.each(function () {
                val += "|" + $(this).html();
            });
            val = val.substring(1);
            hidden.val(val);
        });

        $("#sortablecontainer" + id + " .arrow-all-left").click(function(){
            $("#sortable_conn" + id + " li")
                .detach().appendTo("#sortable" + id + "");
            $(selector).trigger("sortupdate");
        });
        $("#sortablecontainer" + id + " .arrow-all-right").click(function(){
            $("#sortable" + id + " li:not(.hiddend)")
                .detach().appendTo("#sortable_conn" + id);
            $(selector).trigger("sortupdate");
        });
    });

    /**
     * Custom Post types, built in version
     */
    $('div.wpnetbaseCustomPostTypesAll').each(function(){
        var id = $(this).attr('id').match(/^wpnetbaseCustomPostTypesAll-(.*)/)[1];
        var selector = "#sortable" + id +", #sortable_conn" + id;
        var name = $('input[isparam=1]', this).attr('name');

        $(selector).sortable({
            connectWith: ".connectedSortable"
        }, {
            update: function (event, ui) {

            }
        }).disableSelection();
        $(selector).on('sortupdate', function(event, ui) {
            if (typeof(ui)!='undefined')
                var parent = $(ui.item).parent();
            else
                var parent = $(event.target);
            while (!parent.hasClass('wpnetbaseCustomPostTypesAll')) {
                parent = $(parent).parent();
            }
            var items = $('ul[id*=sortable_conn] li', parent);
            var hidden = $('input[name=' + name + ']', parent);
            var val = "";
            items.each(function () {
                val += "|" + $(this).html();
            });
            val = val.substring(1);
            hidden.val(val);
        });

        $("#sortablecontainer" + id + " .arrow-all-left").click(function(){
            $("#sortable_conn" + id + " li")
                .detach().appendTo("#sortable" + id + "");
            $(selector).trigger("sortupdate");
        });
        $("#sortablecontainer" + id + " .arrow-all-right").click(function(){
            $("#sortable" + id + " li:not(.hiddend)")
                .detach().appendTo("#sortable_conn" + id);
            $(selector).trigger("sortupdate");
        });
    });

    /**
     * Custom post types, editable version
     */
    $('div.wpnetbaseCustomPostTypesEditable').each(function(){
        var id = $(this).attr('id').match(/^wpnetbaseCustomPostTypesEditable-(.*)/)[1];
        var selector = "#sortable" + id +", #sortable_conn" + id;
        var name = $('input[isparam=1]', this).attr('name');

        $(selector).keyup(function () {
            var parent = $(this).parent();
            while (!parent.hasClass('wpnetbaseCustomPostTypesEditable')) {
                parent = $(parent).parent();
            }
            var items = $('ul[id*=sortable_conn] li', parent);
            var hidden = $('input[name=' + name + ']', parent);
            var val = "";
            items.each(function () {
                val += "|" + $('label', this).html() + ";" + $('input', this).val();
            });
            val = val.substring(1);
            hidden.val(val);
        });
        $(selector).sortable({
            connectWith: ".connectedSortable"
        }, {
            update: function (event, ui) {
                $("#sortable_conn" + id + " li input").keyup(function () {
                    var parent = $(this).parent();
                    while (!parent.hasClass('wpnetbaseCustomPostTypesEditable')) {
                        parent = $(parent).parent();
                    }
                    var items = $('ul[id*=sortable_conn] li', parent);
                    var hidden = $('input[name=' + name + ']', parent);
                    var val = "";
                    items.each(function () {
                        val += "|" + $('label', this).html() + ";" + $('input', this).val();
                    });
                    val = val.substring(1);
                    hidden.val(val);
                });
                if ($("#sortable_conn" + id + " li input").length != 0) {
                    $("#sortable_conn" + id + " li input").keyup();
                } else {
                    $("#sortable_conn" + id).each(function () {
                        var parent = $(this).parent();
                        while (!parent.hasClass('wpnetbaseCustomPostTypesEditable')) {
                            parent = $(parent).parent();
                        }
                        var hidden = $('input[name=' + name + ']', parent);
                        hidden.val("");
                    });
                }
            }
        });
    });

    /**
     * Custom field selectors
     */
    $('div.wpnetbaseCustomFields').each(function(){
        var id = $(this).attr('id').match(/^wpnetbaseCustomFields-(.*)/)[1];
        var selector = "#sortable" + id +", #sortable_conn" + id;
        var name = $('input[isparam=1]', this).attr('name');

        $(selector).sortable({
            connectWith: ".connectedSortable"
        }, {
            update: function (event, ui) {
            }
        }).disableSelection();

        $(selector).on('sortupdate', function(event, ui) {
            if (typeof(ui)!='undefined')
                var parent = $(ui.item).parent();
            else
                var parent = $(event.target);
            while (!parent.hasClass('wpnetbaseCustomFields')) {
                parent = $(parent).parent();
            }
            var items = $('ul[id*=sortable_conn] li', parent);
            var hidden = $('input[name=' + name + ']', parent);
            var val = "";
            items.each(function () {
                val += "|" + $(this).html();
            });
            val = val.substring(1);
            hidden.val(val);
        });

        $("#sortablecontainer" + id + " .arrow-all-left").click(function(){
            $("#sortable_conn" + id + " li")
                .detach().appendTo("#sortable" + id + "");
            $(selector).trigger("sortupdate");
        });
        $("#sortablecontainer" + id + " .arrow-all-right").click(function(){
            $("#sortable" + id + " li:not(.hiddend)")
                .detach().appendTo("#sortable_conn" + id);
            $(selector).trigger("sortupdate");
        });
    });

    /**
     * Term Meta selectors
     */
    $('div.wwpnetbaseTermMeta').each(function(){
        var id = $(this).attr('id').match(/^wpnetbaseTermMeta-(.*)/)[1];
        var selector = "#sortable" + id +", #sortable_conn" + id;
        var name = $('input[isparam=1]', this).attr('name');

        $(selector).sortable({
            connectWith: ".connectedSortable"
        }, {
            update: function (event, ui) {
            }
        }).disableSelection();

        $(selector).on('sortupdate', function(event, ui) {
            if (typeof(ui)!='undefined')
                var parent = $(ui.item).parent();
            else
                var parent = $(event.target);
            while (!parent.hasClass('wpnetbaseTermMeta')) {
                parent = $(parent).parent();
            }
            var items = $('ul[id*=sortable_conn] li', parent);
            var hidden = $('input[name=' + name + ']', parent);
            var val = "";
            items.each(function () {
                val += "|" + $(this).html();
            });
            val = val.substring(1);
            hidden.val(val);
        });

        $("#sortablecontainer" + id + " .arrow-all-left").click(function(){
            $("#sortable_conn" + id + " li")
                .detach().appendTo("#sortable" + id + "");
            $(selector).trigger("sortupdate");
        });
        $("#sortablecontainer" + id + " .arrow-all-right").click(function(){
            $("#sortable" + id)
                .detach().appendTo("#sortable_conn" + id);
            $(selector).trigger("sortupdate");
        });
    });


    /**
     * Page parent selector
     */
    $('div.wpnetbasePageParents').each(function(){
        var id = $(this).attr('id').match(/^wpnetbasePageParents-(.*)/)[1];
        var selector = "#sortable" + id +", #sortable_conn" + id;
        var name = $('input[isparam=1]', this).attr('name');

        $(selector).sortable({
            connectWith: ".connectedSortable"
        }, {
            update: function (event, ui) {
            }
        }).disableSelection();

        $(selector).on('sortupdate', function(event, ui) {
            if (typeof(ui)!='undefined')
                var parent = $(ui.item).parent();
            else
                var parent = $(event.target);
            while (!parent.hasClass('wpnetbasePageParents')) {
                parent = $(parent).parent();
            }
            var items = $('ul[id*=sortable_conn] li', parent);
            var hidden = $('input[name=' + name + ']', parent);
            var val = "";
            items.each(function () {
                val += "|" + $(this).attr('bid');
            });
            val = val.substring(1);
            hidden.val(val);
        });

        $("#sortablecontainer" + id + " .arrow-all-left").click(function(){
            $("#sortable_conn" + id + " li")
                .detach().appendTo("#sortable" + id + "");
            $(selector).trigger("sortupdate");
        });
        $("#sortablecontainer" + id + " .arrow-all-right").click(function(){
            $("#sortable" + id)
                .detach().appendTo("#sortable_conn" + id);
            $(selector).trigger("sortupdate");
        });
    });

    /**
     * Taxonomy term selector
     */
    $('div.wpnetbaseCustomTaxonomyTerm').each(function(){
        var id = $(this).attr('id').match(/^wpnetbaseCustomTaxonomyTerm-(.*)/)[1];
        var selector = "#sortable" + id +", #sortable_conn" + id;
        var name = $('input[isparam=1]', this).attr('name');
        $(selector).sortable({
            connectWith: ".connectedSortable"
        }, {
            update: function (event, ui) {
            }
        }).disableSelection();
        $("#taxonomy_selector_" + id).change(function () {
            var taxonomy = $(this).val();
            $("li", "#sortable" + id).css('display', 'none').addClass('hiddend');
            $("li[taxonomy='" + taxonomy + "']", "#sortable" + id).css('display', 'block').removeClass('hiddend');
        });
        $("#taxonomy_selector_" + id).change();
        $(selector).on('sortupdate', function(event, ui) {
            if (typeof(ui)!='undefined')
                var parent = $(ui.item).parent();
            else
                var parent = $(event.target);
            while (!parent.hasClass('wpnetbaseCustomTaxonomyTerm')) {
                parent = $(parent).parent();
            }
            var items = $('ul[id*=sortable_conn] li', parent);
            var hidden = $('input[name=' + name + ']', parent);
            var val = "";
            items.each(function () {
                val += "|" + $(this).attr('term_id') + "-" + $(this).attr('taxonomy');
            });
            val = val.substring(1);
            hidden.val(val);
        });
        $("#wpnetbaseCustomTaxonomyTerm-" + id + " .hide-children").change(function(){
            if ($(this).get(0).checked)
                $("#sortablecontainer" + id + " li").filter(':not(.termlevel-0)').css('display', 'none');
            else
                $("#sortablecontainer" + id + " li").filter(':not(.termlevel-0)').css('display', 'block');
            $(selector).trigger("sortupdate");
        });
        $("#sortablecontainer" + id + " .arrow-all-left").click(function(){
            $("#sortable_conn" + id + " li")
                .detach().appendTo("#sortable" + id + "");
            $(selector).trigger("sortupdate");
        });
        $("#sortablecontainer" + id + " .arrow-all-right").click(function(){
            $("#sortable" + id + " li:not(.hiddend)")
                .detach().appendTo("#sortable_conn" + id);
            $(selector).trigger("sortupdate");
        });
    });

    /**
     * Taxonomy term selector with checkboxes
     */
    $('div.wpnetbaseCustomTaxonomyTermSel').each(function(){
        var id = $(this).attr('id').match(/^wpnetbaseCustomTaxonomyTermSel-(.*)/)[1];
        var selector = "#sortable" + id +", #sortable_conn" + id;
        var name = $('input[isparam=1]', this).attr('name');
        var parent = $(this);

        function tt_s_update( parent ) {
            var items = $('ul[id*=sortable_conn] li', parent);
            var hidden = $('input[name=' + name + ']', parent);
            var val = "";
            var checked = [];
            items.each(function () {
                val += "|" + $(this).attr('term_id') + "-" + $(this).attr('taxonomy');
                var $checked = $("input:checkbox:not(:checked)", $(this));
                if ( $checked.length > 0)
                    checked.push( $checked.val() );
            });
            val = val.substring(1) + "|-|" + checked.join("|");
            hidden.val(val);
        }

        $(selector).sortable({
            connectWith: ".connectedSortable"
        }, {
            update: function (event, ui) {
            }
        }).disableSelection();
        $("#taxonomy_selector_" + id).change(function () {
            var taxonomy = $(this).val();
            $("li", "#sortable" + id).css('display', 'none').addClass('hiddend');
            $("li[taxonomy='" + taxonomy + "']", "#sortable" + id).css('display', 'block').removeClass('hiddend');
        });
        $("#taxonomy_selector_" + id).change();
        $(selector).on('sortupdate', function(event, ui) {
            tt_s_update( parent );
        });
        $("#wpnetbaseCustomTaxonomyTermSel-" + id + " .hide-children").change(function(){
            if ($(this).get(0).checked)
                $("#sortablecontainer" + id + " li").filter(':not(.termlevel-0)').css('display', 'none');
            else
                $("#sortablecontainer" + id + " li").filter(':not(.termlevel-0)').css('display', 'block');
            $(selector).trigger("sortupdate");
        });
        $("#sortablecontainer" + id + " .arrow-all-left").click(function(){
            $("#sortable_conn" + id + " li")
                .detach().appendTo("#sortable" + id + "");
            $(selector).trigger("sortupdate");
        });
        $("#sortablecontainer" + id + " .arrow-all-right").click(function(){
            $("#sortable" + id + " li:not(.hiddend)")
                .detach().appendTo("#sortable_conn" + id);
            $(selector).trigger("sortupdate");
        });
        $("#sortable_conn" + id +" li input").change(function(){
            tt_s_update( parent );
        })
    });


    // ----------------------- THEME RELATED ---------------------

    /**
     * Theme Chooser
     *
     * Since 4.5.4 better load balancing and loading bar implemented.
     */
    $('.wpnetbaseThemeChooser select').bind('change', function () {
        var c = confirm('Do you really want to load this template?');
        if (!c) return;
        var parent = $(this);
        while (parent.is('form') != true) {
            parent = parent.parent();
        }
        var themeDiv = $('div[name="' + $(this).val() + '"]');
        var items = JSON.parse( themeDiv.text() );
        var itemsCount = $.map(items, function(n, i) { return i; }).length;

        // Loader start here
        $("#wpd_body_loader").css("display", "block");
        $("#wpd_loading_msg").html("Loading " +  "0/" + itemsCount);

        if ( typeof(items.custom_css_h) == "undefined" )
            $('textarea[name="custom_css_h"]', parent).val("");

        var count = 0;
        var t = null;

        // Delay the start by 1 second for the browser to finish all pending operations
        setTimeout(function() {

            $.each( items, function (key, value) {

                param = $('input[name="' + key + '"]', parent);
                if (param.length == 0)
                    param = $('select[name="' + key + '"]', parent);
                if (param.length == 0)
                    param = $('textarea[name="' + key + '"]', parent);
                param.val(value);

                // Delay execution by 60ms for each item
                setTimeout(function(tc, xparam) {

                    $("#wpd_loading_msg").html("Loading " + tc + "/" + itemsCount);

                    // Abort the execution of the loading removal
                    clearTimeout(t);

                    $( '>.triggerer', xparam.parent() ).trigger("click");

                    // Give 800 milliseconds to render, until the last one reached
                    // then remove the loader. The last timeout is not aborted,
                    // it is executed after 800 ms, finally removing the loading bar.
                    t = setTimeout(function() {

                        $("#wpd_body_loader").css("display", "none");
                        $("#preview .refresh").click();

                    }, (800));

                }, (count * 40), (count +1), param );
                count++;
            });

        }, 1000);

    });

    /**
     * Animation selector
     */
    $('.wpnetbaseAnimations .wpnetbaseanimationselect').change(function () {
        var parent = $(this).parent();
        $('span', parent).removeClass();
        $('span', parent).addClass("asp_an_" + $(this).val());
    });
    $('.wpnetbaseAnimations .triggerer').bind('click', function () {
        var parent = $(this).parent();
        var select = $('select', parent);
        return;
    });

    /**
     * Image Settings
     * The name of the separate params determinates the value outputted in the hidden field.
     */
    $('.wpnetbaseImageSettings input, .wpnetbaseImageSettings select').change(function () {
        var parent = $(this).parent();
        while (parent.hasClass('item') != true) {
            parent = parent.parent();
        }
        var elements = $('input[param!=1], select', parent);
        var hidden = $('input[param=1]', parent);
        var ret = "";
        elements.each(function () {
            ret += $(this).attr("name") + ":" + $(this).val() + ";";
        });
        hidden.val(ret);
    });
    $('.wpnetbaseImageSettings>fieldset>.triggerer').bind("click", function () {
        var elements = $('input[param!=1], select', parent);
        var hidden = $('input[param=1]', parent);
        elements.each(function () {
            var name = $(this).attr("name");
            var regex = new RegExp(".*" + name + ":(.*?);.*");
            val = hidden.val().replace(/(\r\n|\n|\r)/gm, "").match(regex);
            $(this).val(val[1]);
            if ($(this).next().hasClass('triggerer')) $(this).next().click();
        });
    });
    //Image Settings End

    /**
     * Numeric unit related
     */
    $('.wpnetbaseNumericUnit select, .wpnetbaseNumericUnit input[name=numeric]').change(function () {
        var value = "";
        var parent = $(this).parent();
        while (parent.hasClass('wpnetbaseNumericUnit') != true) {
            parent = $(parent).parent();
        }
        var value = $('input[name=numeric]', parent).val() + $('select', parent).val();
        $('input[type=hidden]', parent).val(value);
    });

    $('.wpnetbaseNumericUnit .triggerer').bind('click', function () {
        var value = "";
        var parent = $(this).parent();
        while (parent.hasClass('wpnetbaseNumericUnit') != true) {
            parent = $(parent).parent();
        }
        var hiddenval = $('input[type=hidden]', parent).val();
        var value = hiddenval.match(/([0-9]+)(.*)/)
        $('input[name=numeric]', parent).val(value[1]);
        $('select', parent).val(value[2]);
    });

    /**
     * Image chooser (radio image)
     */
    $('.wpnetbaseImageRadio img.radioimage').click(function () {
        var $parent = $(this).parent();
        var $hidden = $("input[class=realvalue]", $parent);
        $('img.selected', $parent).removeClass('selected');
        $(this).addClass('selected');
        var value = $(this).attr('sel').substring(1);
        $hidden.val(value);
        $hidden.change();
    });
    $('.wpnetbaseImageRadio .triggerer').bind('click', function () {
        var $parent = $(this).parent();
        var $hidden = $("input[class=realvalue]", $parent);
        $('img.selected', $parent).removeClass('selected');
        $('img[src*="' + $hidden.val() + '"]', $parent).addClass('selected');
        $hidden.change();
    });

    /**
     * Loader chooser
     */
    $('.wpnetbaseLoaderSelect .asp-select-loader, .wpnetbaseLoaderSelect .asp-select-loader-selected').click(function () {
        var $parent = $(this).parent();
        var $hidden = $("input[class=realvalue]", $parent);
        $('div.asp-select-loader-selected', $parent)
            .addClass('asp-select-loader')
            .removeClass('asp-select-loader-selected');

        $(this).addClass('asp-select-loader-selected').removeClass('asp-select-loader');
        var value = $(this).attr('sel');
        $hidden.val(value);
        $hidden.change();
    });
    $('.wpnetbaseLoaderSelect .triggerer').bind('click', function () {
        var $parent = $(this).parent();
        var $hidden = $("input[class=realvalue]", $parent);
        $('div.asp-select-loader-selected', $parent)
            .addClass('asp-select-loader')
            .removeClass('asp-select-loader-selected');

        $('div[sel*="' + $hidden.val() + '"]', $parent)
            .addClass('asp-select-loader-selected')
            .removeClass('asp-select-loader');

        $hidden.change();
    });

    /**
     * Spectrum: color chooser
     */
    $(".wpnetbaseColorPicker .color").spectrum({
        showInput: true,
        showAlpha: true,
        showPalette: true,
        showSelectionPalette: true
    });
    $('.wpnetbaseColorPicker .triggerer').bind('click', function () {
        function hex2rgb(hex, opacity) {
            var rgb = hex.replace('#', '').match(/(.{2})/g);

            var i = 3;
            while (i--) {
                rgb[i] = parseInt(rgb[i], 16);
            }

            if (typeof opacity == 'undefined') {
                return 'rgb(' + rgb.join(', ') + ')';
            }

            return 'rgba(' + rgb.join(', ') + ', ' + opacity + ')';
        }

        var parent = $(this).parent();
        var input = $('input.color', parent);
        var val = input.val();
        if (val.length <= 7) val = hex2rgb(val, 1);
        input.spectrum("set", val);
    });

    /**
     * Gradient chooser
     */
    $(".wpnetbaseGradient .color, .wpnetbaseGradient .grad_type, .wpnetbaseGradient .dslider").change(function () {
        var $parent = $(this);
        while (!$parent.hasClass('wpnetbaseGradient')) {
            $parent = $parent.parent();
        }
        var $hidden = $('input.gradient', $parent);
        var $colors = $('input.color', $parent);
        var $type = $('select.grad_type', $parent);
        var $dslider = $('div.dslider', $parent);
        var $grad_ex = $('div.grad_ex', $parent);
        var $dbg = $('div.dbg', $parent);
        var $dtxt = $('div.dtxt', $parent);

        $dbg.css({
            "-webkit-transform": "rotate(" + $dslider.slider('value') + "deg)",
            "-moz-transform": "rotate(" + $dslider.slider('value') + "deg)",
            "transform": "rotate(" + $dslider.slider('value') + "deg)"
        });
        $dtxt.html($dslider.slider('value'));

        grad($grad_ex, $($colors[0]).val(), $($colors[1]).val(), $type.val(), $dslider.slider('value'));

        $hidden.val(
            $type.val() + '-' +
                $dslider.slider('value') + '-' +
                $($colors[0]).val() + '-' +
                $($colors[1]).val()
        );
        $hidden.change();
    });
    $(".wpnetbaseGradient>.triggerer").click(function () {
        var $parent = $(this).parent();
        var $hidden = $('input.gradient', $parent);
        var $colors = $('input.color', $parent);
        var $dslider = $('div.dslider', $parent);
        var $type = $('select.grad_type', $parent);
        var colors = $hidden.val().match(/(.*?)-(.*?)-(.*?)-(.*)/);

        if (colors == null || colors[1] == null) {
            //Fallback to older 1 color
            $type.val(0);
            $dslider.slider('value', 0);
            $($colors[0]).spectrum('set', $hidden.val());
            $($colors[1]).spectrum('set', $hidden.val());
        } else {
            $type.val(colors[1]);
            $dslider.slider('value', colors[2]);
            $($colors[0]).val(colors[3]);
            $($colors[1]).val(colors[4]);

            $($colors[0]).spectrum('set', colors[3]);
            $($colors[1]).spectrum('set', colors[4]);
        }
    });
    function grad(el, c1, c2, t, d) {
        if (t != 0) {
            $(el).css('background-image', '-webkit-linear-gradient(' + d + 'deg, ' + c1 + ', ' + c2 + ')')
                .css('background-image', '-moz-linear-gradient(' + d + 'deg,  ' + c1 + ',  ' + c2 + ')')
                .css('background-image', '-ms-linear-gradient(' + d + 'deg,  ' + c1 + ',  ' + c2 + ')')
                .css('background-image', 'linear-gradient(' + d + 'deg,  ' + c1 + ',  ' + c2 + ')')
                .css('background-image', '-o-linear-gradient(' + d + 'deg,  ' + c1 + ',  ' + c2 + ')');
        } else {
            $(el).css('background-image', '-webkit-radial-gradient(center, ellipse cover, ' + c1 + ', ' + c2 + ')')
                .css('background-image', '-moz-radial-gradient(center, ellipse cover, ' + c1 + ',  ' + c2 + ')')
                .css('background-image', '-ms-radial-gradient(center, ellipse cover, ' + c1 + ',  ' + c2 + ')')
                .css('background-image', 'radial-gradient(ellipse at center, ' + c1 + ',  ' + c2 + ')')
                .css('background-image', '-o-radial-gradient(center, ellipse cover, ' + c1 + ',  ' + c2 + ')');
        }
    }

    /**
     * TextShadow chooser
     */
    $('.wpnetbaseTextShadow input[type=text]').change(function () {
        var value = "";
        var parent = $(this).parent();
        while (parent.hasClass('wpnetbaseTextShadow') != true) {
            parent = $(parent).parent();
        }
        var hlength = $.trim($('input[name*="_xx_hlength_xx_"]', parent).val()) + "px ";
        var vlength = $.trim($('input[name*="_xx_vlength_xx_"]', parent).val()) + "px ";
        var blurradius = $.trim($('input[name*="_xx_blurradius_xx_"]', parent).val()) + "px ";
        var color = $.trim($('input[name*="_xx_color_xx_"]', parent).val()) + " ";
        var boxshadow = "text-shadow:" + hlength + vlength + blurradius + color;
        $('input[type=hidden]', parent).val(boxshadow);
        $('input[type=hidden]', parent).change();
    });
    $('.wpnetbaseTextShadow>fieldset>.triggerer').bind('click', function () {
        var parent = $(this).parent();
        var hidden = $("input[type=hidden]", parent);
        var boxshadow = hidden.val().replace(/(\r\n|\n|\r)/gm, "").match(/box-shadow:(.*?)px (.*?)px (.*?)px (.*?);/);

        $('input[name*="_xx_hlength_xx_"]', parent).val(boxshadow[1]) + "px ";
        $('input[name*="_xx_vlength_xx_"]', parent).val(boxshadow[2]) + "px ";
        $('input[name*="_xx_blurradius_xx_"]', parent).val(boxshadow[3]) + "px ";
        $('input[name*="_xx_color_xx_"]', parent).val(boxshadow[4]) + " ";
        $('input[name*="_xx_color_xx_"]', parent).keyup();
    });

    /**
     * BoxShadow chooser
     */
    $('.wpnetbaseBoxShadow input[type=text], .wpnetbaseBoxShadow select').change(function () {
        var value = "";
        var parent = $(this).parent();
        while (parent.hasClass('wpnetbaseBoxShadow') != true) {
            parent = $(parent).parent();
        }
        var hlength = $.trim($('input[name*="_xx_hlength_xx_"]', parent).val()) + "px ";
        var vlength = $.trim($('input[name*="_xx_vlength_xx_"]', parent).val()) + "px ";
        var blurradius = $.trim($('input[name*="_xx_blurradius_xx_"]', parent).val()) + "px ";
        var spread = $.trim($('input[name*="_xx_spread_xx_"]', parent).val()) + "px ";
        var color = $.trim($('input[name*="_xx_color_xx_"]', parent).val()) + " ";
        var inset = $.trim($('select[name*="_xx_inset_xx_"]', parent).val()) + ";";
        var boxshadow = "box-shadow:" + hlength + vlength + blurradius + spread + color + inset;

        $('input[type=hidden]', parent).val(boxshadow);
        $('input[type=hidden]', parent).change();
    });
    $('.wpnetbaseBoxShadow>fieldset>.triggerer').bind('click', function () {
        var parent = $(this).parent();
        var hidden = $("input[type=hidden]", parent);
        var boxshadow = hidden.val().replace(/(\r\n|\n|\r)/gm, "").match(/box-shadow:(.*?)px (.*?)px (.*?)px (.*?)px (.*?)\) (.*?);/);
        var plus = ")";
        if (boxshadow == null) {
            boxshadow = hidden.val().replace(/(\r\n|\n|\r)/gm, "").match(/box-shadow:(.*?)px (.*?)px (.*?)px (.*?)px (.*?) (.*?);/);
            plus = '';
        }
        $('input[name*="_xx_hlength_xx_"]', parent).val(boxshadow[1]);
        $('input[name*="_xx_vlength_xx_"]', parent).val(boxshadow[2]);
        $('input[name*="_xx_blurradius_xx_"]', parent).val(boxshadow[3]);
        $('input[name*="_xx_spread_xx_"]', parent).val(boxshadow[4]);
        $('input[name*="_xx_color_xx_"]', parent).val(boxshadow[5] + plus);
        $('select[name*="_xx_inset_xx_"]', parent).val(boxshadow[6]);
        $('input[name*="_xx_color_xx_"]', parent).spectrum('set', boxshadow[5] + plus);
    });

    /**
     * Border chooser
     */
    $('.wpnetbaseBorder input[type=text], .wpnetbaseBorder select').bind("change", function () {
        var value = "";
        var parent = $(this).parent();
        while (parent.hasClass('wpnetbaseBorder') != true) {
            parent = $(parent).parent();
        }
        var width = $('input[name*="_xx_width_xx_"]', parent).val() + "px ";
        var style = $('select[name*="_xx_style_xx_"]', parent).val() + " ";
        var color = $('input[name*="_xx_color_xx_"]', parent).val() + ";";
        var border = "border:" + width + style + color;

        var topleft = $.trim($('input[name*="_xx_topleft_xx_"]', parent).val()) + "px ";
        var topright = $.trim($('input[name*="_xx_topright_xx_"]', parent).val()) + "px ";
        var bottomright = $.trim($('input[name*="_xx_bottomright_xx_"]', parent).val()) + "px ";
        var bottomleft = $.trim($('input[name*="_xx_bottomleft_xx_"]', parent).val()) + "px;";
        var borderradius = "border-radius:" + topleft + topright + bottomright + bottomleft;

        var value = border + borderradius;

        $('input[type=hidden]', parent).val(value);
        $('input[type=hidden]', parent).change();
    });
    $('.wpnetbaseBorder>fieldset>.triggerer').bind('click', function () {
        var parent = $(this).parent();
        var hidden = $("input[type=hidden]", parent);
        var border = hidden.val().replace(/(\r\n|\n|\r)/gm, "").match(/border:(.*?)px (.*?) (.*?);/);
        $('input[name*="_xx_width_xx_"]', parent).val(border[1]);
        $('select[name*="_xx_style_xx_"]', parent).val(border[2]);
        $('input[name*="_xx_color_xx_"]', parent).val(border[3]);

        var borderradius = hidden.val().replace(/(\r\n|\n|\r)/gm, "").match(/border-radius:(.*?)px(.*?)px(.*?)px(.*?)px;/);
        $('input[name*="_xx_topleft_xx_"]', parent).val(borderradius[1]);
        $('input[name*="_xx_topright_xx_"]', parent).val(borderradius[2]);
        $('input[name*="_xx_bottomright_xx_"]', parent).val(borderradius[3]);
        $('input[name*="_xx_bottomleft_xx_"]', parent).val(borderradius[4]);
        $('input[name*="_xx_color_xx_"]', parent).spectrum('set', border[3]);
    });

    /**
     * Border Radius chooser
     */
    $('.wpnetbaseBorderRadius input[type=text]').change(function () {
        var value = "";
        $('input[type=text]', $(this).parent()).each(function () {
            value += " " + $(this).val() + "px";
        });
        $('input[type=hidden]', $(this).parent()).val("border-radius:" + value + ";");
        $('input[type=hidden]', $(this).parent()).change();
    });
    $('.wpnetbaseBorderRadius>fieldset>.triggerer').bind('click', function () {
        var hidden = $("input[type=hidden]", $(this).parent());
        var values = hidden.val().match(/(.*?)px(.*?)px(.*?)px(.*?)px;/);
        var i = 1;
        $('input[type=text]', $(this).parent()).each(function () {
            if ($(this).attr('name') != null) {
                $(this).val(values[i]);
                i++;
            }
        });
    });


    // ----------------------- ETC.. ---------------------

    $('.successMsg').each(function () {
        $(this).delay(4000).fadeOut();
    });
    $('img.delete').click(function () {
        var del = confirm("Do yo really want to delete this item?");
        if (del) {
            $(this).next().submit();
        }
    });

});
