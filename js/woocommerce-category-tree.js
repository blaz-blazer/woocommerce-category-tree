jQuery(document).ready(function($){
  //on page load expand parents of active category
  $('.wct-categories').find('.wct--active').parents('.wct-sub-categories, .wct-sub-sub-categories').toggleClass('wct--visible');
  //on page load handle expand elements
  $('.wct-categories').find('.wct--active').parents('.wct-sub-categories, .wct-sub-sub-categories').siblings('.sub-category-expand, .main-category-expand').toggleClass('expanded');

  //expand subcategories and hide sub categories and sub sub categories
  $('.main-category-expand').click(function(event) {
    $(this).parent().children('.wct-sub-categories').toggleClass('wct--visible');
    //also hide subsubcategories
    $(this).parent().children('.wct-sub-categories').children('.wct-sub-category ').children('.wct-sub-sub-categories').removeClass('wct--visible');
    //change expand span on subcategories
    $(this).parent().children().find('.expanded').toggleClass('expanded');
    //add class to clicked element
    $(this).toggleClass('expanded');
  });

  //expand/hide sub sub categories
  $('.sub-category-expand').click(function(event) {
    $(this).parent().children('.wct-sub-sub-categories').toggleClass('wct--visible');
    //add class to clicked element
    $(this).toggleClass('expanded');
  });
});
