document.addEventListener( 'DOMContentLoaded' , function(){
    var cf7pe_form = document.getElementById( 'wpcf7-admin-form-element' ); // Paypal tab form element

    // Add submit event for paypal form
    if ( cf7pe_form == true )
    {
        cf7pe_form.addEventListener( "submit" , function( evt ){

           // evt.preventDefault();   

            var paypal_form    = document.getElementsByClassName( 'paypal_form' );
            var inputElements = paypal_form[0].querySelectorAll( 'input, select, checkbox, textarea' );

            for ( index = 0; index < inputElements.length; ++index ) {

               var inputobj  = inputElements[ index ];
               var checktype = inputobj.getAttributeNode( "type" );
               inputobj.classList.remove( "error" ); 
               if ( checktype != null )
               {
                   // Check email validation
                   if (checktype.value == "email" )
                   {
                       if ( inputobj.value == '' ) 
                          inputobj.classList.add( "error" );
                       else
                       {
                           if ( !validateEmail(inputobj.value) ) 
                              inputobj.classList.add( "error" );
                       }

                   }

                   // Check URL validation
                   if ( checktype.value == "url" )
                   {
                      if (    inputobj.value !='' 
                           && !ValidateUrl(inputobj.value)
                         )
                        {
                            inputobj.classList.add( "error" );       
                        }
                   }

                   if ( inputElements[index].classList.contains( "error" ) )
                     evt.preventDefault( ); 
               }
            }

        });
    }
    // Validate email method
    function validateEmail( email ) {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/;
        return re.test( String(email).toLowerCase() );
    }

    // Validate URL method
    function ValidateUrl( url )
    {
        var re = /(?:^|[ \t])((https?:\/\/)?(?:localhost|[\w-]+(?:\.[\w-]+)+)(:\d+)?(\/\S*)?)/;
        return re.test( String(url).toLowerCase() );
    }
});
