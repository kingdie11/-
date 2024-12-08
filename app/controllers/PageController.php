<?php
class PageController extends Controller {

    public function sendEmail() {
       
            // Handle GET request or other methods
            $this->view('send'); // Load the view for sending emails
        
    }    
    public function viewjob() {
       
        // Handle GET request or other methods
        $this->view('jobs'); // Load the view for sending emails
    
    }    
    public function viewcontact() {
       
        // Handle GET request or other methods
        $this->view('contact'); // Load the view for sending emails
    
    }    

    public function viewadminhome() {
       
        // Handle GET request or other methods
        $this->view('adminhome'); // Load the view for sending emails
    
    }  

    public function viewforgotpass() {
       
        // Handle GET request or other methods
        $this->view('verifyemailuser'); // Load the view for sending emails
    
    }  

    public function viewsecurityq() {
       
        // Handle GET request or other methods
        $this->view('verifyquestionuser'); // Load the view for sending emails
    
    }
    
    public function viewabout() {
       
        // Handle GET request or other methods
        $this->view('about'); // Load the view for sending emails
    
    }
}
