<div>
    <x-slot name="title">
        Contact
    </x-slot>
    <div class="uk-section">
        <div class="uk-container uk-margin-small-top uk-margin-bottom">
            <div class="uk-grid uk-flex uk-flex-center in-contact-6">
                <div class="uk-width-1-1">
                    <iframe class="uk-width-1-1 uk-height-large uk-border-rounded"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3608.1954637182694!2d55.293989415359526!3d25.264009335185612!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e5f433f66de8f0b%3A0x7e3552f9bab892e7!2s59%20Ali%20Bin%20Abi%20Taleb%20St%20-%20Al%20Fahidi%20-%20Dubai%20-%20United%20Arab%20Emirates!5e0!3m2!1sen!2sbd!4v1640083508481!5m2!1sen!2sbd">
                    </iframe>
                </div>
                <div class="uk-width-3-5@m">
                    <div class="uk-grid uk-child-width-1-3@m uk-margin-medium-top uk-text-center" data-uk-grid>
                        <div>
                            <h5 class="uk-margin-remove-bottom"><i
                                    class="fas fa-map-marker-alt fa-sm uk-margin-small-right"></i>Address</h5>
                            <p class="uk-margin-small-top">{{ config('app.address') }}</p>
                        </div>
                        <div>
                            <h5 class="uk-margin-remove-bottom"><i
                                    class="fas fa-envelope fa-sm uk-margin-small-right"></i>Emails</h5>
                            <p class="uk-margin-small-top uk-margin-remove-bottom">Support: {{ config('app.email') }}
                            </p>

                        </div>
                        <div>
                            <h5 class="uk-margin-remove-bottom"><i
                                    class="fas fa-phone-alt fa-sm uk-margin-small-right"></i>Phone line</h5>
                            <p class="uk-margin-small-top uk-margin-remove-bottom">{{ config('app.phone') }}</p>
                            <h5 class="uk-margin-remove-bottom"><i
                                    class="fas fa-phone-alt fa-sm uk-margin-small-right"></i>Opening hours :</h5>
                            <p class="uk-margin-small-top uk-margin-remove-bottom">9:00 UTC+2 - 18:00 UTC+2</p>

                        </div>

                    </div>
                    <hr class="uk-margin-medium">

                    <h1 class="uk-margin-small-top uk-text-center"> <span class="in-highlight">Contact Us</span></h1>
                    <p class="uk-margin-remove-bottom uk-text-lead uk-text-muted uk-text-center"><a
                            href="#">Home</a> /Contact Us</p>
                    <form id="contact-form" class="uk-form uk-grid-small uk-margin-medium-top" data-uk-grid>
                        <div class="uk-width-1-2@s uk-inline">
                            <span class="uk-form-icon fas fa-user fa-sm"></span>
                            <input class="uk-input uk-border-rounded" id="name" name="name" type="text"
                                placeholder="Full name">
                        </div>
                        <div class="uk-width-1-2@s uk-inline">
                            <span class="uk-form-icon fas fa-envelope fa-sm"></span>
                            <input class="uk-input uk-border-rounded" id="email" name="email" type="email"
                                placeholder="Email address">
                        </div>
                        <div class="uk-width-1-1 uk-inline">
                            <span class="uk-form-icon fas fa-phone-alt fa-sm"></span>
                            <input class="uk-input uk-border-rounded" id="subject" name="subject" type="text"
                                placeholder="Phone">
                        </div>
                        <div class="uk-width-1-1">
                            <textarea class="uk-textarea uk-border-rounded" id="message" name="message" rows="6" placeholder="Message"></textarea>
                        </div>
                        <div class="uk-width-1-1">
                            <button class="uk-width-1-1 uk-button uk-button-primary uk-border-rounded" id="sendemail"
                                type="submit" name="submit">Send Message</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
