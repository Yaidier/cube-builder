class Cube_Builder_Main {
    static instance() {
        if (!Cube_Builder_Main.instance_obj) {

            this.editor_panel                   = document.querySelector( '.cb-editor' );
            this.wp_wrapper                     = document.querySelector( 'div#page.site' );
            this.all_widgets                    = document.querySelectorAll( '.cb-widget[cube-id]' );
            Cube_Builder_Main.instance_obj      = this;

        }

        return Cube_Builder_Main.instance_obj;
    }

    static init() {
        this.init_editor_panel();
        this.init_wp_wrapper();
        this.register_widgets( this.all_widgets );
    }

    static init_editor_main_tabs() {
        let editor_main_tabs    = this.editor_panel.querySelectorAll( '.cb-editor_main_tabs > li' ),
            self                = this;

        Array.prototype.forEach.call( editor_main_tabs, ( tab ) => {
            tab.addEventListener( 'click', () => {
                let all_content_tabs            = self.editor_panel.querySelectorAll( '.cb-editor_main_tab_contents' ),
                    section_name                = tab.getAttribute( 'section-name' ),
                    content_element_to_display  = self.editor_panel.querySelector( '#cb-editor_main_tab_content-' + section_name );

                Array.prototype.forEach.call( all_content_tabs, ( content_tab ) => {
                    let corresonping_tab_id = content_tab.id.replace( 'cb-editor_main_tab_content-', '' ),
                        corresonping_tab    = self.editor_panel.querySelector( '.cb-editor_main_tabs > li[section-name="' + corresonping_tab_id + '"]' );
                        
                    corresonping_tab.classList.remove( 'cb_active_tab' );
                    content_tab.classList.add( 'cb_display_none' );
                } );

                tab.classList.add( 'cb_active_tab' );
                content_element_to_display.classList.remove( 'cb_display_none' );


            } );
        });
    }

    static init_editor_panel(){
        let body_element = document.querySelector( 'body' );

        if( !this.editor_panel ) {
            return;
        }
        body_element.appendChild(this.editor_panel);
        this.editor_panel.classList.remove( 'cb_display_none' );
    }

    static init_wp_wrapper() {
        this.wp_wrapper.style.transition = 'padding-left 0.4s ease';
    }

    static register_widgets( widgets ) {
        if ( !widgets || widgets.length == 0 ) {
            return;
        }

        Array.prototype.forEach.call(widgets, ( widget ) => {
            if( ! widget.getAttribute( 'cube-id' ) ) {
                return;
            }

            this.register_edit_button( widget );
        });
    }

    static register_edit_button( widget ) {
        let edit_button = widget.querySelector( '.cb-widget_editor_buttons button.cb-widget_edit_button' ),
            cube_id     = widget.getAttribute( 'cube-id' );

        edit_button.addEventListener( 'click', () => {
            if( this.editor_panel.classList.contains( 'cb_silde_from_left' ) ) {
                this.editor_panel.classList.remove( 'cb_silde_from_left' );
                this.wp_wrapper.style.paddingLeft = '0px';
            }
            else {
                this.send_content_to_the_editor( cube_id );
                this.init_editor_main_tabs();
                this.editor_panel.classList.add( 'cb_silde_from_left' );
                this.wp_wrapper.style.paddingLeft = '350px';
            }
        } );
    }

    static send_content_to_the_editor( cube_id ) {
        let target_content_to_bring_to_editor   = this.editor_panel.querySelector( '.cb-editor_content[editor-content-for="' + cube_id + '"]' ),
            all_contents_currently_in_editor    = this.editor_panel.querySelectorAll( '.cb-editor_content' );

        if( all_contents_currently_in_editor ) {
            Array.prototype.forEach.call( all_contents_currently_in_editor, ( content_in_editor ) => {
                content_in_editor.style.display = 'none';
            } );
        }

        if( target_content_to_bring_to_editor ) {
            target_content_to_bring_to_editor.style.display = 'block';
        }
        else {
            target_content_to_bring_to_editor = document.querySelector( '.cb-editor_content[editor-content-for="' + cube_id + '"]' );
            this.editor_panel.appendChild( target_content_to_bring_to_editor );
        }
    }
}

document.addEventListener("DOMContentLoaded", () => {
    Cube_Builder_Main.instance().init();
});
