document.addEventListener("DOMContentLoaded", function(){
    var formele = document.getElementsByClassName("wpcf7-form")[0]; // Paypal  form element
    set_hidden_field_value();
   
    // Add submit event for paypal form
    if(formele)
    {
        formele.addEventListener("submit", function(evt){
            
            set_hidden_field_value();
            
        });
    }


    document.addEventListener( 'wpcf7mailsent', function( event ) {
           formele.submit();
   }, false );
});


function set_hidden_field_value()
{
    if(typeof document.getElementsByName("item_name_field")[0] != "undefined")
        var itemname_field=document.getElementsByName("item_name_field")[0].value;
    if(typeof document.getElementsByName("item_number_field")[0] != "undefined") 
        var itemnum_field=document.getElementsByName("item_number_field")[0].value;
    if(typeof document.getElementsByName("quantity_field")[0] != "undefined") 
        var quantity_field=document.getElementsByName("quantity_field")[0].value;
    if(typeof document.getElementsByName("amount_field")[0] != "undefined") 
        var amount_field=document.getElementsByName("amount_field")[0].value;

    if(typeof document.getElementsByName(itemname_field)[0] != "undefined")
        document.getElementsByName('item_name')[0].value=document.getElementsByName(itemname_field)[0].value;
    if(typeof document.getElementsByName(itemnum_field)[0] != "undefined")
        document.getElementsByName('item_number')[0].value=document.getElementsByName(itemnum_field)[0].value;
    if(typeof document.getElementsByName(quantity_field)[0] != "undefined")
        document.getElementsByName('quantity')[0].value=document.getElementsByName(quantity_field)[0].value;
    if(typeof document.getElementsByName(amount_field)[0] != "undefined")
        document.getElementsByName('amount')[0].value=document.getElementsByName(amount_field)[0].value;
}