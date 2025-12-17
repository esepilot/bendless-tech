// BendlessTech Core Plugin JavaScript

(function($) {
    'use strict';
    
    // Website Development Lead Form
    $('#website-lead-form').on('submit', function(e) {
        e.preventDefault();
        
        var $form = $(this);
        var $button = $form.find('.submit-btn');
        var $message = $form.find('.form-message');
        
        // Disable button
        $button.prop('disabled', true).text('Submitting...');
        $message.remove();
        
        // Collect form data
        var formData = {
            action: 'submit_website_lead',
            nonce: bendlesstechAjax.nonce,
            business_name: $form.find('[name="business_name"]').val(),
            contact_name: $form.find('[name="contact_name"]').val(),
            whatsapp: $form.find('[name="whatsapp"]').val(),
            email: $form.find('[name="email"]').val(),
            industry: $form.find('[name="industry"]').val(),
            website_type: $form.find('[name="website_type"]').val(),
            features: $form.find('[name="features"]').val(),
            budget_range: $form.find('[name="budget_range"]').val(),
            notes: $form.find('[name="notes"]').val()
        };
        
        // Submit via AJAX
        $.post(bendlesstechAjax.ajaxurl, formData, function(response) {
            if (response.success) {
                $form.before('<div class="form-message success">' + response.data.message + '</div>');
                $form[0].reset();
            } else {
                $form.before('<div class="form-message error">' + response.data.message + '</div>');
            }
        }).fail(function() {
            $form.before('<div class="form-message error">An error occurred. Please try again.</div>');
        }).always(function() {
            $button.prop('disabled', false).text('Submit Request');
        });
    });
    
    // Inventory System Lead Form
    $('#inventory-lead-form').on('submit', function(e) {
        e.preventDefault();
        
        var $form = $(this);
        var $button = $form.find('.submit-btn');
        var $message = $form.find('.form-message');
        
        // Disable button
        $button.prop('disabled', true).text('Submitting...');
        $message.remove();
        
        // Collect form data
        var formData = {
            action: 'submit_inventory_lead',
            nonce: bendlesstechAjax.nonce,
            business_name: $form.find('[name="business_name"]').val(),
            contact_name: $form.find('[name="contact_name"]').val(),
            whatsapp: $form.find('[name="whatsapp"]').val(),
            email: $form.find('[name="email"]').val(),
            industry: $form.find('[name="industry"]').val(),
            inventory_size: $form.find('[name="inventory_size"]').val(),
            num_products: $form.find('[name="num_products"]').val(),
            num_users: $form.find('[name="num_users"]').val(),
            features: $form.find('[name="features"]').val(),
            challenges: $form.find('[name="challenges"]').val(),
            notes: $form.find('[name="notes"]').val()
        };
        
        // Submit via AJAX
        $.post(bendlesstechAjax.ajaxurl, formData, function(response) {
            if (response.success) {
                $form.before('<div class="form-message success">' + response.data.message + '</div>');
                $form[0].reset();
            } else {
                $form.before('<div class="form-message error">' + response.data.message + '</div>');
            }
        }).fail(function() {
            $form.before('<div class="form-message error">An error occurred. Please try again.</div>');
        }).always(function() {
            $button.prop('disabled', false).text('Submit Request');
        });
    });
    
    // Contact Form
    $('#contact-form').on('submit', function(e) {
        e.preventDefault();
        
        var $form = $(this);
        var $button = $form.find('.submit-btn');
        var $message = $form.find('.form-message');
        
        // Disable button
        $button.prop('disabled', true).text('Sending...');
        $message.remove();
        
        // Collect form data
        var formData = {
            action: 'submit_contact_form',
            nonce: bendlesstechAjax.nonce,
            name: $form.find('[name="name"]').val(),
            email: $form.find('[name="email"]').val(),
            whatsapp: $form.find('[name="whatsapp"]').val(),
            message: $form.find('[name="message"]').val()
        };
        
        // Submit via AJAX
        $.post(bendlesstechAjax.ajaxurl, formData, function(response) {
            if (response.success) {
                $form.before('<div class="form-message success">' + response.data.message + '</div>');
                $form[0].reset();
            } else {
                $form.before('<div class="form-message error">' + response.data.message + '</div>');
            }
        }).fail(function() {
            $form.before('<div class="form-message error">An error occurred. Please try again.</div>');
        }).always(function() {
            $button.prop('disabled', false).text('Send Message');
        });
    });
    
    // Smooth scroll for anchor links
    $('a[href^="#"]').on('click', function(e) {
        var target = $(this.getAttribute('href'));
        if (target.length) {
            e.preventDefault();
            $('html, body').stop().animate({
                scrollTop: target.offset().top - 80
            }, 800);
        }
    });
    
})(jQuery);
