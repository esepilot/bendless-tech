// StayDesk Platform JavaScript

(function($) {
    'use strict';
    
    // Initialize Paystack payment
    window.initPaystackPayment = function(email, amount, planType, hotelId) {
        $.post(staydeskAjax.ajaxurl, {
            action: 'init_paystack_payment',
            nonce: staydeskAjax.nonce,
            email: email,
            amount: amount,
            plan_type: planType,
            hotel_id: hotelId
        }, function(response) {
            if (response.success) {
                window.location.href = response.data.authorization_url;
            } else {
                alert('Failed to initialize payment');
            }
        });
    };
    
    // Verify payment after redirect
    if (window.location.search.indexOf('reference=') > -1) {
        var urlParams = new URLSearchParams(window.location.search);
        var reference = urlParams.get('reference');
        
        if (reference) {
            $.post(staydeskAjax.ajaxurl, {
                action: 'verify_paystack_payment',
                nonce: staydeskAjax.nonce,
                reference: reference
            }, function(response) {
                if (response.success) {
                    alert('Payment successful! Your subscription is now active.');
                    window.location.href = '/staydesk/dashboard';
                } else {
                    alert('Payment verification failed');
                }
            });
        }
    }
    
    // Booking form submission
    $('#booking-form').on('submit', function(e) {
        e.preventDefault();
        
        var formData = {
            action: 'create_booking',
            nonce: staydeskAjax.nonce
        };
        
        $(this).serializeArray().forEach(function(item) {
            formData[item.name] = item.value;
        });
        
        $.post(staydeskAjax.ajaxurl, formData, function(response) {
            if (response.success) {
                alert('Booking created successfully! Reference: ' + response.data.booking_reference);
                location.reload();
            } else {
                alert(response.data.message);
            }
        });
    });
    
    // Room management
    $('#add-room-form').on('submit', function(e) {
        e.preventDefault();
        
        var formData = {
            action: 'add_room',
            nonce: staydeskAjax.nonce
        };
        
        $(this).serializeArray().forEach(function(item) {
            formData[item.name] = item.value;
        });
        
        $.post(staydeskAjax.ajaxurl, formData, function(response) {
            if (response.success) {
                alert('Room added successfully!');
                location.reload();
            } else {
                alert(response.data.message);
            }
        });
    });
    
    // Update booking status
    $('.update-booking-status').on('click', function() {
        var bookingId = $(this).data('booking-id');
        var status = $(this).data('status');
        
        if (confirm('Are you sure you want to update this booking status?')) {
            $.post(staydeskAjax.ajaxurl, {
                action: 'update_booking_status',
                nonce: staydeskAjax.nonce,
                booking_id: bookingId,
                status: status
            }, function(response) {
                if (response.success) {
                    alert('Booking status updated!');
                    location.reload();
                } else {
                    alert(response.data.message);
                }
            });
        }
    });
    
    // Cancel subscription
    $('#cancel-subscription').on('click', function() {
        if (confirm('Are you sure you want to cancel your subscription? It will remain active until the end of the current billing period.')) {
            $.post(staydeskAjax.ajaxurl, {
                action: 'cancel_subscription',
                nonce: staydeskAjax.nonce
            }, function(response) {
                if (response.success) {
                    alert('Subscription cancelled successfully');
                    location.reload();
                } else {
                    alert(response.data.message);
                }
            });
        }
    });
    
})(jQuery);
