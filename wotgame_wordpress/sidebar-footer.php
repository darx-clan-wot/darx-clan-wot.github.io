<?php
global $theme_sidebars;
$places = array();
foreach ($theme_sidebars as $sidebar){
    if ($sidebar['group'] !== 'footer')
        continue;
    $widgets = theme_get_dynamic_sidebar_data($sidebar['id']);
    if (!is_array($widgets) || count($widgets) < 1)
        continue;
    $places[$sidebar['id']] = $widgets;
}
$place_count = count($places);
$needLayout = ($place_count > 1);
if (theme_get_option('theme_override_default_footer_content')) {
    if ($place_count > 0) {
        $centred_begin = '<div class="wotgame-center-wrapper"><div class="wotgame-center-inner">';
        $centred_end = '</div></div><div class="clearfix"> </div>';
        if ($needLayout) { ?>
<div class="wotgame-content-layout">
    <div class="wotgame-content-layout-row">
        <?php 
        }
        foreach ($places as $widgets) { 
            if ($needLayout) { ?>
            <div class="wotgame-layout-cell wotgame-layout-cell-size<?php echo $place_count; ?>">
            <?php 
            }
            $centred = false;
            foreach ($widgets as $widget) {
                 $is_simple = ('simple' == $widget['style']);
                 if ($is_simple) {
                     $widget['class'] = implode(' ', array_merge(explode(' ', theme_get_array_value($widget, 'class', '')), array('wotgame-footer-text')));
                 }
                 if (false === $centred && $is_simple) {
                     $centred = true;
                     echo $centred_begin;
                 }
                 if (true === $centred && !$is_simple) {
                     $centred = false;
                     echo $centred_end;
                 }
                 theme_print_widget($widget);
            } 
            if (true === $centred) {
                echo $centred_end;
            }
            if ($needLayout) {
           ?>
            </div>
        <?php 
            }
        } 
        if ($needLayout) { ?>
    </div>
</div>
        <?php 
        }
    }
?>
<div class="wotgame-footer-text">
<?php
global $theme_default_options;
echo do_shortcode(theme_get_option('theme_override_default_footer_content') ? theme_get_option('theme_footer_content') : theme_get_array_value($theme_default_options, 'theme_footer_content'));
} else { 
?>
<div class="wotgame-footer-text">
<?php theme_ob_start() ?>
  
<div class="wotgame-content-layout">
    <div class="wotgame-content-layout-row">
    <div class="wotgame-layout-cell" style="width: 33%"><?php if (false === theme_print_sidebar('footer-1-widget-area')) { ?>
        <p><br /></p>
    <?php } ?></div><div class="wotgame-layout-cell" style="width: 34%"><?php if (false === theme_print_sidebar('footer-2-widget-area')) { ?>
        <p><br /></p>
    <?php } ?></div><div class="wotgame-layout-cell" style="width: 33%"><?php if (false === theme_print_sidebar('footer-3-widget-area')) { ?>
        <p><br /></p>
    <?php } ?></div>
    </div>
</div>
<div class="wotgame-content-layout">
    <div class="wotgame-content-layout-row">
    <div class="wotgame-layout-cell" style="width: 100%"><?php if (false === theme_print_sidebar('footer-4-widget-area')) { ?>
        <p><br /></p>
    <?php } ?></div>
    </div>
</div>


<?php echo do_shortcode(theme_ob_get_clean()) ?>
<?php } ?>

</div>
