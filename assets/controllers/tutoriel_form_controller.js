import {Controller} from "@hotwired/stimulus";

export default class extends Controller
{
    connect()
    {
        this.element.addEventListener('live:connect', (event) => {
            this.component = event.detail.component;
            this.component.on('render:finished', (component) => {
                const ckeditors = document.querySelectorAll("[data-main-target='ckeditor']")
                for (let editor of ckeditors) {
                    const scripts = editor.parentElement.getElementsByTagName('script');
                    eval(scripts[0].innerHTML);
                    eval(scripts[2].innerHTML);
                    let editorId = editor.id;
                    // eslint-disable-next-line no-undef
                    CKEDITOR.instances[editorId].on('blur', () => {
                        editor.dispatchEvent(new Event('change', { bubbles: true }));
                    })
                }
            });
        });
    }
}
