var Preview = {
    insertCss: function(css){
        return '<style type="text/css">' + css + '.merge_tag_ok {background-color: #00ff00;} .merge_tag_ko {background-color: #ff0000;}' + '</style>';
    },
    colorizeMergeTags: function(html, definedIdentifiers){
        var regexp = new RegExp("{[_a-z0-9]*}", "g");
        htmlIdentifiers = html.match(regexp);

        var i;
        for (i in htmlIdentifiers) {
            var pattern = htmlIdentifiers[i];
            var regexp = new RegExp(pattern, "g");
            var spanClass = 'merge_tag_ko';

            if (jQuery.inArray(htmlIdentifiers[i], definedIdentifiers) >= 0){
                spanClass = 'merge_tag_ok';
            }
            html = html.replace(regexp, "<span class=\"" + spanClass + "\">" + htmlIdentifiers[i] + "</span>");
        }

        return html;
    },
    render: function(){
        var definedIdentifiers = ["{last_name}", "{first_name}"];
        var $html = $('input[name*="html"]').val();
        var $css = $('input[name*="css"]').val();
        $html = this.colorizeMergeTags($html, definedIdentifiers);

        var sourceCode = $html + this.insertCss($css);
        $('#preview').contents().find('body').html(sourceCode);
    }
};
