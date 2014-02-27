
// GeneratorPreview

function GeneratorPreview($container, $textareaHtml, $textareaCss, definedMergeIdentifiers, definedConfigurationIdentifiers) {
    this.$container                      = $container;
    this.$textareaHtml                   = $textareaHtml;
    this.$textareaCss                    = $textareaCss;
    this.definedMergeIdentifiers         = definedMergeIdentifiers;
    this.definedConfigurationIdentifiers = definedConfigurationIdentifiers;
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
    return '<style type="text/css">' + content + '\n' +
               ' .tag_ok {background-color: #00ff00;}'+
               ' .tag_ko {background-color: #ff0000;}'+
               ' .tag_alt {background-color: #00ffff;}'+
           '</style>';
}

GeneratorPreview.prototype.renderBody = function(content) {
    var match, regexp;

    // Color variables beetween {{ .. }} and remove brackets
    regexp = /{{( )?([_a-z0-9]*)( )?}}/g;
    while (match = regexp.exec(content)) {
        var spanClass = 'tag_ko';
        if (jQuery.inArray(match[2], this.definedMergeIdentifiers) >= 0){
            spanClass = 'tag_ok';
        }
        // The content is replaced only if it is not a configuration tag (because potentially it has to add span tag in another tag)
        if (jQuery.inArray(match[2], this.definedConfigurationIdentifiers) < 0){
            content = content.replace(match[0], '<span class="' + spanClass + '">' + match[2] + '</span>');
        }
    }

    // Remove matching text
    regexp = /{%( )?(if.*?)( )?%}/g; // {% if .. %}
    while (match = regexp.exec(content)) {
        content = content.replace(match[0], '');
    }
    regexp = /{%( )?else( )?%}/g;    // {% else %}
    while (match = regexp.exec(content)) {
        content = content.replace(match[0], '');
    }
    regexp = /{%( )?endif( )?%}/g;   // {% else %}
    while (match = regexp.exec(content)) {
        content = content.replace(match[0], '');
    }

    return content;
}

GeneratorPreview.prototype.render = function() {
    var css = this.renderCss(this.$textareaCss.val());
    var body = this.renderBody(this.$textareaHtml.val());
    this.$container.contents().find('body').html(body + css);
}
