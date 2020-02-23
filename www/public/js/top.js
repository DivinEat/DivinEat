function scrollTo(id) {
    var e = document.getElementById(id);
    var menu = document.querySelector("nav");
    var box = e.getBoundingClientRect();
    var k, inc, z, s;
    var delta = menu.getBoundingClientRect().bottom;
    z = box.top - delta;
    inc = (z >= 0) ? 1 : -1;
    for (k = 0; k < 49; k++) {
        s = "window.scrollBy(0," + Math.floor(z / 50) + ")";
        setTimeout(s, 10 * k);
    }
    s = "myLastScrollTo('" + id + "'," + delta + ")";
    setTimeout(s, 500);
}

function myLastScrollTo(id, delta) {
    var e = document.getElementById(id);
    var box = e.getBoundingClientRect();
    if ($(window).width() <= 980){
        window.scrollBy(0, box.top - 150);
    } else {
        if($('#header2').css('display') == 'none')
        {
            window.scrollBy(0, box.top - delta);
        }
        else {
            window.scrollBy(0, box.top - 70);
        }
    }
  }