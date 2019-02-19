document.addEventListener( 'DOMContentLoaded' , function( ){
    var cf7pe_form = document.getElementsByClassName( 'wpcf7-form' )[0]; // Paypal  form element
    set_hidden_field_value();
   
    // Add submit event for paypal form
    if ( cf7pe_form == true )
    {
        cf7pe_form.addEventListener( "submit" , function( event ) {
           set_hidden_field_value();
       });
    }


    document.addEventListener( 'wpcf7mailsent', function( event ) {
           cf7pe_form.submit();
   }, false );
});


function set_hidden_field_value( )
{
    if ( typeof document.getElementsByName('item_name_field')[0] != "undefined" )
        var itemname_field = document.getElementsByName('item_name_field')[0].value;
    if ( typeof document.getElementsByName('item_number_field')[0] != "undefined" ) 
        var itemnum_field  = document.getElementsByName('item_number_field')[0].value;
    if ( typeof document.getElementsByName('quantity_field')[0] != "undefined" ) 
        var quantity_field = document.getElementsByName('quantity_field')[0].value;
    if ( typeof document.getElementsByName('amount_field')[0] != "undefined" ) 
        var amount_field   = document.getElementsByName('amount_field')[0].value;

    if ( typeof document.getElementsByName(itemname_field)[0] != "undefined" )
        document.getElementsByName('item_name')[0].value   = document.getElementsByName(itemname_field)[0].value;
    if ( typeof document.getElementsByName(itemnum_field)[0] != "undefined" )
        document.getElementsByName('item_number')[0].value = document.getElementsByName(itemnum_field)[0].value;
    if ( typeof document.getElementsByName(quantity_field)[0] != "undefined" )
        document.getElementsByName('quantity')[0].value    = document.getElementsByName(quantity_field)[0].value;
    if ( typeof document.getElementsByName(amount_field)[0] != "undefined" )
        document.getElementsByName('amount')[0].value      = document.getElementsByName(amount_field)[0].value;
}