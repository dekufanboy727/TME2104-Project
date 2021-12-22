function validateForm()
{
    //declaration
    let fname = document.reg.fname.value;
    let lname = document.reg.lname.value;
    let email = document.reg.email.value;
    let phone = document.reg.mobile.value;
    let pw = document.reg.pw.value;
    let cpw = document.reg.cpw.value;
    let address = document.reg.Address.value;
    let postcode = document.reg.Postcode.value;
    let city = document.reg.city.value;
    
    
    //validate first name
    if(fname == "" ||  fname == null)
    {
        alert("First name cannot not be Empty!");
        return false;
    }
    else if (fname != null)
    {
        let bool = ValidateName(fname);
        if( bool == false)
        {
            return false;
        }
    }

    //validate last name
    if(lname == "" ||  lname == null)
    {
        alert("Last name cannot not be Empty!");
        return false;
    }
    else if(lname != null)
    {
        let bool = ValidateName(lname);
        if( bool == false)
        {
            return false;
        }
    }

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

    //validate phone
    if(phone == "" ||  phone == null)
    {
        alert("Phone cannot not be Empty!");
        return false;
    }
    else if(phone != null)
    {
        let bool = ValidatePhone(phone);
        if( bool == false)
        {
            return false;
        }
    }

    //validate password
    if(pw == "" ||  pw == null)
    {
        alert("Password cannot not be Empty!");
        return false;
    }
    else if (pw != null)
    {
        let bool = ValidatePw(pw);
        if( bool == false)
        {
            return false;
        }
    }

    //validate confirm password
    if(cpw == "" ||  cpw == null)
    {
        alert("Confirm Password cannot not be Empty!");
        return false;
    }
    else if (cpw != null)
    {
        let bool = ValidateCpw(cpw, pw);
        if( bool == false)
        {
            return false;
        }
    }

    //validate whether the gender is checked
    if(!document.getElementById("male").checked && !document.getElementById("female").checked)
    {
        alert("Please select your gender!");
        return false;
    }

    //validate address
    if( address  == ""  )
    {
        alert("Address is Required!");
        return false;
    }
    
    //Validate postcode
    if(postcode == "" )
    {
        alert("Postcode is Required!");
        return false;
    }
    else if (postcode != "")
    {
        let bool = ValidatePostcode(postcode);
        if( bool == false)
        {
             return false;
        }
    }
    
    //validate city
    if( city  == ""  )
    {
        alert("City is Required!");
        return false;
    }
    
    //validate if the terms is checked
    if(!document.getElementById("terms").checked)
    {
        alert("Please accept the terms and condition!");
        return false;
    }
    else //all validations do not return false 
    {
        alert("Registration Sucessful!");
        return true;
    }
}

function ValidateName(name) //Validate first and last name
{
    let x = 0;

    if(name.charAt(0) !== name.charAt(0).toUpperCase())
    {
        alert("Please capitalise FIRST CHARACTER of your Name!");
        return false;
    }
    else //Check whether the other characters are in lower case?
    {
        
        for(x=1; x<name.length; x++)
        {
            if(name.charAt(x) === " ")//Next word
            {
                x++;
                if(name.charAt(x) !== name.charAt(x).toUpperCase())
                {
                    alert("Please capitalise FIRST CHARACTER of your Name!");
                    return false;
                }
            }
            else if(name.charAt(x) !== name.charAt(x).toLowerCase())
            {
                alert("Please make sure your Name are all in lowercase except the FIRST character!");
                return false;
            }
            
        }

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

function ValidatePhone(phone) //Validate phone number
{
    if(isNaN(phone)) //not numbers
    {
        alert("Please use a valid phone number with only numbers 0-9!");
        return false;
    }
    else if(phone.length> 10 || phone.length < 9) //Too short or too long
    {
         alert("Please use a valid phone number with correct length!");
         return false;
    }
}

function ValidatePw(pw) //Validate password
{
    var numbers = ('[0-9]');
    var Lalphabet = ('[a-z]');
    var Ualphabet = ('[A-Z]');
    var specialC = ('[!@#$%^&*]');
    var whitespace = /\s/; //find whitespace
    
    if(pw.length <6) //Less than 6 digits
    {
        alert("Please use a password with at least 6 digits!");
        return false;
    }
    else if(!pw.match(numbers) || !pw.match(Lalphabet) || !pw.match(Ualphabet) || !pw.match(specialC))
    {
        alert("Please use an alphanumberic password with at least ONE upppercase, ONE lowercase, ONE special character and numbers !");
        return false;
    }
    else if(pw.match(whitespace)) //If whitespace found
    {
        alert("Please make sure there is no white space in the password!");
        return false;
    }
}

function ValidateCpw (cpw, pw)
{
    if(cpw !== pw) //password is valid, now check whether the confirm pw is the same with the pw
    {
        alert("Please make sure the confirm password is the same with the password!");
        return false;
    }
}

function ValidatePostcode(pc) //Validate postcode
{
    if(isNaN(pc)) //Not numbers
    {
        alert("Please use a valid Postcode with only numbers 0-9!");
        return false;
    }
    else if(pc.length> 5 || pc.length < 5)
    {
        alert("Please use a valid postcode with correct length!");
        return false;
    }
}