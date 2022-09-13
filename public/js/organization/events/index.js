$(document).on('click', '.confirm-submit', function(event){
    event.preventDefault();
    const confirmation = confirm('Tem certeza que deseja excluir?');
    
    if(confirmation){
        const form = $(this).parent();

        form.trigger('submit');
    }
})