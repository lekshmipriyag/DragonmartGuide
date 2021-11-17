<?php
class AjaxSearchWidget extends WP_Widget {
    public function __construct() {
        $widget_ops = array('classname' => 'AjaxSearchWidget', 'description' => 'Displays an Ajax Search!' );
        parent::__construct('AjaxSearchWidget', 'NBT Ajax Search', $widget_ops);
    }
    public function form($instance) {
        $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">
                Title:
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                       name="<?php echo $this->get_field_name('title'); ?>" type="text"
                       value="<?php echo esc_attr($title); ?>" />
            </label>
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = $new_instance['title'];
        return $instance;
    }

    public function widget($args, $instance) {
        extract($args, EXTR_SKIP);
        echo $before_widget;
        $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
        if (!empty($title))
            echo $before_title . $title . $after_title;;
        // WIDGET CODE GOES HERE
        echo do_shortcode("[wpnetbase_ajaxsearch]");
        echo $after_widget;
    }
}