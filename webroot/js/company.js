// document.querySelector('#suburb').addEventListener('input',
//     function (e) {
//         console.log(e.target.value)
//     }
// )
$(document).ready(function () {
    $(window).keydown(function (event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            return false;
        }
    });

    $('#state').selectpicker({
        liveSearch: true
    });

    let contactContainer = $('#contact-container')
    let contactTemplate = _.template($('#contact-template').remove().text());
    let numbersRows = contactContainer.find('.contact-row').length;
    let addContactButton = $('#add-contact-button');
    addContactButton.on('click',function (e){
        e.preventDefault();
        $(contactTemplate({key: numbersRows++})).hide().appendTo(contactContainer).fadeIn('fast')
    })
    contactContainer.on('click','a.contact-delete',function (e){
        e.preventDefault();
        $(this).closest('.row').fadeOut('fast',function (){
            $(this).remove()
        })
    })
})
