!function (t) {
    t.fn.printPreview = function (e) {
        var i = this, r = t.extend({
            obj2print: "body",
            style: "",
            width: "670",
            height: screen.height - 105,
            top: 0,
            left: "center",
            resizable: "yes",
            scrollbars: "yes",
            status: "no",
            title: "Print Preview"
        }, e);
        return "center" == r.left && (r.left = screen.width / 2 - r.width / 2), i.bind("click.printPreview", function () {
            var e = i[0].outerHTML, n = "";
            n = t("head").html();
            var l = "<!DOCTYPE html><html><head>" + n + r.style + "</head><body>";
            l += t(r.obj2print)[0].outerHTML.replace(e, "") + "<script > window.print();  </script></body></html>";
            var o = window.open("", "newWindow", "width=" + r.width + ",top=" + r.top + ",height=" + r.height + ",left=" + r.left + ",resizable=" + r.resizable + ",scrollbars=" + r.scrollbars + ",status=" + r.status);
            o.document.write(l); o.document.title = r.title;
            // o.print();
        })
        //
    }
}(jQuery);
