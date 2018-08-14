
let leftButton_Menu =
    "<div class=\"navbar-btn left-button\">\n" +
    "    <a onclick=\"toggleMenu()\"><img src=\"img/tabicon/menu.png\" alt=\"菜单\"></a>\n" +
    "</div>";
let leftButton_Close =
    "<div class=\"navbar-btn left-button\">\n" +
    "    <a onclick=\"toggleMenu()\"><img src=\"img/tabicon/close.png\" alt=\"关闭\"></a>\n" +
    " </div>";
let rightButton_Add =
    "<div class=\"navbar-btn right-button\">\n" +
    "    <a href=\"edit.php\"><img src=\"img/tabicon/add.png\" alt=\"添加\"></a>\n" +
    "</div>";



$(function () {
    // INIT
    setMenuHeight();
    $('#navbar').prepend(leftButton_Menu).prepend(rightButton_Add);
    $('.menu-panel').load("menu.html");



    // list
    $('.list-header').click(function () {
        $(this).next().slideToggle("easing");
    });

    // RESIZE
    $(window).resize(function () {
        setMenuHeight();
    });

    function setMenuHeight() {
        $('.menu-panel').css({
            height: window.innerHeight
        });
    }
});


function toggleMenu() {
    $('.left-button, .right-button').remove();
    let menu = $('.menu-panel');
    if (menu.css("display") != "none") {
        menu.css("display", "none");
        $('#navbar').prepend(leftButton_Menu).prepend(rightButton_Add);
        menu.load("menu.html");
    } else {
        menu.css("display", "block");
        $('#navbar').prepend(leftButton_Close);
        $('.content').css("scrool")
    }
}