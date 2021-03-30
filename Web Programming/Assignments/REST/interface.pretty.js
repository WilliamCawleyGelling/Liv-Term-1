/**
 * submits the request to the websevice and returns the information in json format.]
 * is used when submit button it pressed. 
 */
function submit() { 
    console.log('starting transaction...' );
    var htmlmethod = document.getElementById('HTMLmethod').value
    var resource = document.getElementById('resource').value
    var input = document.getElementById('request').value
    //these were used when debugging to make sure the correct values were being used.
    //console.log(htmlmethod);
    //console.log(resource);
    //console.log(input)
    var request = new XMLHttpRequest() 
    if (resource.match(/^([a-zA-Z]+[\/]?)+/) != null ){
        request.open(htmlmethod, 'https://student.csc.liv.ac.uk/~sgwcawle/v1/' + resource, true)        
        request.onreadystatechange = function() {
            console.log(this.readyState + ": " + this.responseText + " " +
                this.status)
            if (this.readyState == 4) {
                document.getElementById('response').innerHTML =  this.responseText 
                    this.status
                document.getElementById('responseCode').innerHTML =this.status
            }
        }
        console.log('Sending XMLHttpRequest...');
        request.send(input)
    } else {
        document.getElementById('response').innerHTML =  'Bad Request'
        document.getElementById('responseCode').innerHTML =  400
    }

}

/**
 * clears the response and responsecode areas.
 * activates onclick of clear Response button. 
 */
function clearResponse()  {
    document.getElementById('response').innerHTML = '';
    document.getElementById('responseCode').innerHTML ='';

}
