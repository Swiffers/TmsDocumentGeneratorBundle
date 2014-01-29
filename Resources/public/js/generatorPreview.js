
// GeneratorPreview

function GeneratorPreview($container, $textareaHtml, $textareaCss, definedIdentifiers) {
    this.$container         = $container;
    this.$textareaHtml      = $textareaHtml;
    this.$textareaCss       = $textareaCss;
    this.definedIdentifiers = definedIdentifiers;
    this.initListeners();
    this.render();
}

GeneratorPreview.prototype.initListeners = function() {
    var that = this;
    this.$textareaHtml.on('change', function(){
        that.render();
    });
    this.$textareaCss.on('change', function(){
        that.render();
    });
}

GeneratorPreview.prototype.renderCss = function(content) {
    return '<style type="text/css">' + content + '\n' + '.merge_tag_ok {background-color: #00ff00;} .merge_tag_ko {background-color: #ff0000;}</style>';
}

GeneratorPreview.prototype.renderBody = function(content) {
    var regexp = new RegExp("{[_a-z0-9]*}", "g");
    htmlIdentifiers = content.match(regexp);

    var i;
    for (i in htmlIdentifiers) {
        var pattern = htmlIdentifiers[i];
        var regexp = new RegExp(pattern, "g");
        var spanClass = 'merge_tag_ko';

        needle = htmlIdentifiers[i].replace('{', '').replace('}', '');
        if (jQuery.inArray(needle, this.definedIdentifiers) >= 0){
            spanClass = 'merge_tag_ok';
        }
        content = content.replace(regexp, "<span class=\"" + spanClass + "\">" + htmlIdentifiers[i] + "</span>");
    }

    return content;
}

GeneratorPreview.prototype.render = function() {
    var css = this.renderCss(this.$textareaCss.val());
    var body = this.renderBody(this.$textareaHtml.val());
    this.$container.contents().find('body').html(body + css);
}
