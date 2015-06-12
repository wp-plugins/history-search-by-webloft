jQuery(window).load(function(){

jQuery("#gridcontainer").fadeIn(2000);
//document.getElementById('gridcontainer').style.display = "initial";
jQuery('.grid').masonry({
  // options
  itemSelector: '.grid-item'
});



});
