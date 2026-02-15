new DataTable('#example');


function eliminar() {
   let rta = confirm("¿Estás seguro de eliminar este registro?");
   return rta;
}


$(document).ready(function() {
    
    // Abre/Cierra el menú lateral al hacer clic en el botón de toggle
    $('#menu-toggle').click(function() {
        $('#side-menu').toggleClass('open');
    });

    // Cierra el menú al hacer clic en el ícono 'X' dentro del menú
    $('#menu-close').click(function() {
        $('#side-menu').removeClass('open');
    });

    // Opcional: Cierra el menú si se hace clic fuera de él (útil para la experiencia de usuario)
    $(document).mouseup(function(e) {
        var menu = $('#side-menu');
        var toggle = $('#menu-toggle');
        
        // Si el clic no está en el menú ni en el botón de toggle
        if (!menu.is(e.target) && menu.has(e.target).length === 0 && !toggle.is(e.target) && toggle.has(e.target).length === 0) {
            if (menu.hasClass('open')) {
                menu.removeClass('open');
            }
        }
    });
});