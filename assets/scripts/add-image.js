// assets/scripts/add-image.js

document.addEventListener('DOMContentLoaded', function() {
    const addImageButton = document.createElement('button');
    addImageButton.type = 'button';
    addImageButton.innerText = 'Ajouter une image';
    addImageButton.className = 'btn btn-secondary mb-3';

    const imageList = document.querySelector('ul.images');
    if (imageList) {
        imageList.appendChild(addImageButton);

        addImageButton.addEventListener('click', function() {
            const prototype = imageList.dataset.prototype;
            const index = imageList.children.length - 1; // Soustrayez 1 pour ignorer le bouton
            const newForm = prototype.replace(/__name__/g, index);
            const newFormItem = document.createElement('li');
            newFormItem.innerHTML = newForm;
            imageList.insertBefore(newFormItem, addImageButton);
        });
    }
});