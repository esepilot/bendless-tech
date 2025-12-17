// StayDesk Chat Widget JavaScript

(function() {
    'use strict';
    
    class StayDeskWidget {
        constructor(config) {
            this.hotelId = config.hotelId;
            this.apiUrl = config.apiUrl || '/wp-json/staydesk-widget/v1/chat';
            this.language = 'english';
            this.sessionId = this.generateSessionId();
            this.init();
        }
        
        generateSessionId() {
            return 'session_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
        }
        
        init() {
            this.injectStyles();
            this.createWidget();
            this.attachEventListeners();
            this.sendInitialGreeting();
        }
        
        injectStyles() {
            const link = document.createElement('link');
            link.rel = 'stylesheet';
            link.href = '<?php echo STAYDESK_WIDGET_URL; ?>assets/css/widget.css';
            document.head.appendChild(link);
        }
        
        createWidget() {
            const container = document.createElement('div');
            container.className = 'staydesk-widget-container';
            container.innerHTML = `
                <div class="staydesk-widget-chat" id="staydesk-chat">
                    <div class="staydesk-widget-header">
                        <div>
                            <h3 id="staydesk-hotel-name">Chat with us</h3>
                            <div class="staydesk-widget-status">Online • We typically reply instantly</div>
                        </div>
                        <button class="staydesk-widget-close" id="staydesk-close">×</button>
                    </div>
                    <div class="staydesk-widget-messages" id="staydesk-messages"></div>
                    <div class="staydesk-language-switch">
                        <button id="staydesk-lang-toggle">Switch to Pidgin</button>
                    </div>
                    <div class="staydesk-widget-input-area">
                        <input 
                            type="text" 
                            class="staydesk-widget-input" 
                            id="staydesk-input"
                            placeholder="Type your message..."
                        >
                        <button class="staydesk-widget-send" id="staydesk-send">➤</button>
                    </div>
                </div>
                <button class="staydesk-widget-button" id="staydesk-button">💬</button>
            `;
            document.body.appendChild(container);
        }
        
        attachEventListeners() {
            const button = document.getElementById('staydesk-button');
            const chat = document.getElementById('staydesk-chat');
            const close = document.getElementById('staydesk-close');
            const send = document.getElementById('staydesk-send');
            const input = document.getElementById('staydesk-input');
            const langToggle = document.getElementById('staydesk-lang-toggle');
            
            button.addEventListener('click', () => {
                chat.classList.toggle('active');
            });
            
            close.addEventListener('click', () => {
                chat.classList.remove('active');
            });
            
            send.addEventListener('click', () => {
                this.sendMessage();
            });
            
            input.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    this.sendMessage();
                }
            });
            
            langToggle.addEventListener('click', () => {
                this.toggleLanguage();
            });
        }
        
        toggleLanguage() {
            this.language = this.language === 'english' ? 'pidgin' : 'english';
            const toggle = document.getElementById('staydesk-lang-toggle');
            toggle.textContent = this.language === 'english' ? 'Switch to Pidgin' : 'Switch to English';
        }
        
        sendInitialGreeting() {
            setTimeout(() => {
                this.sendMessageToBot('hello', true);
            }, 1000);
        }
        
        sendMessage() {
            const input = document.getElementById('staydesk-input');
            const message = input.value.trim();
            
            if (!message) return;
            
            this.addMessage(message, 'user');
            input.value = '';
            
            this.sendMessageToBot(message);
        }
        
        sendMessageToBot(message, isInitial = false) {
            if (!isInitial) {
                this.showTypingIndicator();
            }
            
            fetch(this.apiUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    hotel_id: this.hotelId,
                    message: message,
                    language: this.language,
                    session_id: this.sessionId,
                }),
            })
            .then(response => response.json())
            .then(data => {
                this.hideTypingIndicator();
                if (data.message) {
                    this.addMessage(data.message, 'bot');
                }
                if (data.session_id) {
                    this.sessionId = data.session_id;
                }
            })
            .catch(error => {
                this.hideTypingIndicator();
                this.addMessage('Sorry, something went wrong. Please try again.', 'bot');
                console.error('StayDesk Widget Error:', error);
            });
        }
        
        addMessage(text, sender) {
            const messagesContainer = document.getElementById('staydesk-messages');
            const messageDiv = document.createElement('div');
            messageDiv.className = `staydesk-message ${sender}`;
            
            const bubble = document.createElement('div');
            bubble.className = 'staydesk-message-bubble';
            bubble.textContent = text;
            
            messageDiv.appendChild(bubble);
            messagesContainer.appendChild(messageDiv);
            
            // Scroll to bottom
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }
        
        showTypingIndicator() {
            const messagesContainer = document.getElementById('staydesk-messages');
            const indicator = document.createElement('div');
            indicator.className = 'staydesk-message bot';
            indicator.id = 'staydesk-typing';
            indicator.innerHTML = `
                <div class="staydesk-message-bubble">
                    <div class="staydesk-typing-indicator">
                        <div class="staydesk-typing-dot"></div>
                        <div class="staydesk-typing-dot"></div>
                        <div class="staydesk-typing-dot"></div>
                    </div>
                </div>
            `;
            messagesContainer.appendChild(indicator);
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }
        
        hideTypingIndicator() {
            const indicator = document.getElementById('staydesk-typing');
            if (indicator) {
                indicator.remove();
            }
        }
    }
    
    // Initialize widget when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initWidget);
    } else {
        initWidget();
    }
    
    function initWidget() {
        const hotelId = document.currentScript.getAttribute('data-hotel-id');
        if (hotelId) {
            window.stayDeskWidget = new StayDeskWidget({
                hotelId: hotelId
            });
        } else {
            console.error('StayDesk Widget: hotel-id attribute is required');
        }
    }
})();
