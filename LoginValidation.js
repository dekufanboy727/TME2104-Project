function validateForm()
{
    //Declarations
    let email = document.login.email.value;
    let pw = document.login.pw.value;

    //validate email
    if(email == "" ||  email == null)
    {
        alert("Email cannot not be Empty!");
        return false;
    }
    else if(email != null)
    {
        let bool = ValidateEmail(email);
        if( bool == false)
        {
            return false;
        }
    }

    if(pw == "" ||  pw == null)
    {
        alert("Password cannot not be Empty!");
        return false;
    }
}

function ValidateEmail(email) //Validate email
{
    var RegEmail =  /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9]+\.com$/;
    if(!email.match(RegEmail))
    {
        alert("Please use a valid Email following the format: something@domain.com");
        return false;
    }
}