import Errors from './Errors';

class Form {
    /**
     * Create a new Form instance.
     *
     */

    constructor(data){
        this.errors = new Errors();
        this.action = '';
        this.method = '';
        this.redirect = '';

        for (const [key, val] of Object.entries(data)) {            
            this[key] = val; //console.log(`${key}: ${val}`);
        }

        this.validate();
    }   

    validate(){    
        if(this.action === undefined || this.action == ''){
            throw new Error("[e-doklad] Form: Unknown `action`!");
        }

        if(this.method === undefined || this.method == ''){
            throw new Error("[e-doklad] Form: Unknown `method`!");
        }

        return true;
    }

    /**
     * Init form data using form DOM id
     * 
     * @param {*} form_id 
     */
    initWithFormID(form_id) {  
        let theForm = document.getElementById(form_id); 
        let formData = new FormData(theForm);
        // need to convert it before using not with XMLHttpRequest
        for (let [key, val] of formData.entries()) {                      
            this[key] = val;
        }  
        this.validate();
    }

    /**
     * Fetch all relevant data for the form.
     */
    data() {
        let data = Object.assign({}, this);
        delete data.errors;
        delete data.action;
        delete data.method;
        delete data.redirect;

        return data;
    }

   
    /**
     * Reset the form fields.
     */
    reset() {
        for (let field in this.data()) {
            this[field] = '';
        }

        this.errors.clear();
    }


    /**
     * Send a POST request to the given URL.
     * .
     * @param {string} url
     */
    post(url='') {
        return this.submit('post', url);
    }


    /**
     * Send a PUT request to the given URL.
     * .
     * @param {string} url
     */
    put(url='') {
        return this.submit('put', url);
    }


    /**
     * Send a PATCH request to the given URL.
     * .
     * @param {string} url
     */
    patch(url='') {
        return this.submit('patch', url);
    }


    /**
     * Send a DELETE request to the given URL.
     * .
     * @param {string} url
     */
    delete(url='') {
        return this.submit('delete', url);
    }


    /**
     * Submit the form.
     *
     * @param {string} requestType
     * @param {string} url
     */
    submit(requestType='post', url='#') {
        
        if(this.method != '') requestType = this.method;
        if(this.action != '') url = this.action;

        return new Promise((resolve, reject) => {
            axios[requestType](url, this.data())
                .then(response => {
                    this.onSuccess(response.data);                    
                    resolve(response.data);
                })
                .catch(error => {                                              
                    this.onFail(error.response.data.errors);
                    reject(error.response.data.errors);
                });
        });
    }


    /**
     * Handle a successful form submission.
     *
     * @param {object} data
     */
    onSuccess(data) {
        this.reset();
    }


    /**
     * Handle a failed form submission.
     *
     * @param {object} errors
     */
    onFail(errors) {
        this.errors.record(errors);
    }
}

export default Form;