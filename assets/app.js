/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

// start the Stimulus application
import './bootstrap';
import starFull from './images/star_full.png';
import starEmpty from './images/star_empty.png';

require('bootstrap')

document.getElementById('favoris').addEventListener('click', addFavori);
function addFavori(event) {
    event.preventDefault();
    const favoriLink = event.currentTarget;
    const link = favoriLink.href;

    fetch(link)
        .then(response => response.json())
        .then(data => {
            const favoriIcon = favoriLink.firstElementChild;

            if (data.isFavori) {
                favoriIcon.setAttribute('src', starFull);
            } else {
                favoriIcon.setAttribute('src', starEmpty);
            }
        });

}
