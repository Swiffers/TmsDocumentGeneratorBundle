
// GeneratorPreview

function GeneratorPreview($container, editorHtml, editorCss, definedIdentifiers) {
    this.$container = $container;
    this.editorHtml = editorHtml;
    this.editorCss = editorCss;
    this.definedIdentifiers = definedIdentifiers;
    this.initListeners();
    this.render();
}

GeneratorPreview.prototype.initListeners = function() {
    var that = this;
    this.editorHtml.getSession().on('change', function() {
        that.render();
    });
    this.editorCss.getSession().on('change', function() {
        that.render();
    });
}

GeneratorPreview.prototype.renderCss = function(content) {
    return '<style type="text/css">' + content + '\n' +
               ' .merge_tag_ok {background-color: #00ff00;}'+
               ' .merge_tag_ko {background-color: #ff0000;}'+
               ' .merge_tag_alt {background-color: #00ffff;}'+
           '</style>';
}

GeneratorPreview.prototype.renderBody = function(content) {
    var match,regexp;

    // Color variables beetween {{ .. }} and remove brackets
    regexp = /{{( )?([_a-z0-9]*)( )?}}/g;
    while (match = regexp.exec(content)) {
        var spanClass = 'merge_tag_ko';
        if (jQuery.inArray(match[2], this.definedIdentifiers) >= 0){
            spanClass = 'merge_tag_ok';
        }
        content = content.replace(match[0], "<span class=\"" + spanClass + "\">" + match[2] + "</span>");
    }

    regexp = /{%( )?(if.*?)( )?%}/g; // {% if .. %}
    while (match = regexp.exec(content)) {
        content = content.replace(match[0], "");
    }
    regexp = /{%( )?else( )?%}/g;    // {% else %}
    while (match = regexp.exec(content)) {
        content = content.replace(match[0], "");
    }
    regexp = /{%( )?endif( )?%}/g;   // {% else %}
    while (match = regexp.exec(content)) {
        content = content.replace(match[0], "");
    }

    return content;
}

GeneratorPreview.prototype.render = function() {
    var css = this.renderCss(this.editorCss.getSession().getValue());
    var body = this.renderBody(this.editorHtml.getSession().getValue());

    this.$container.contents().find('body').html(body + css);
}
