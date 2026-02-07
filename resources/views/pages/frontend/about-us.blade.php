<div>
    <x-slot name="title">
        About Us
    </x-slot>

    <div class="uk-section uk-padding-remove-vertical">
        <img src="{{ asset('frontend/img/company.jpg') }}" alt="logo" width="100%">
    </div>
    <!-- section content begin -->
    <div class="uk-section">
        <div class="uk-container">
            <div class="uk-grid">
                <div class="uk-width-1-1 uk-flex uk-flex-center">
                    <div class="uk-width-3-5@m uk-text-center">
                        <h1 class="uk-margin-remove"><span class="in-highlight">{{ config('app.name') }}</span> is a
                            Reliable, Safe & Fair Trading Platform</h1>
                        <p class="uk-text-lead uk-text-muted uk-margin-small-top">For more than 10 years, we’ve been
                            empowering clients by helping them take control of their financial lives.</p>
                    </div>
                </div>
                <div class="uk-grid uk-grid-large uk-child-width-1-3@m uk-margin-medium-top" data-uk-grid>
                    <div class="uk-flex uk-flex-left">
                        <div class="uk-margin-right">
                            <i class="fas fa-leaf fa-lg in-icon-wrap primary-color"></i>
                        </div>
                        <div>
                            <h3>Equinix Data Center</h3>
                            <p> Our services are hosted in Equinix data centers. Equinix owns and safely operates more
                                than 220 data centers around the world.</p>
                        </div>
                    </div>
                    <div class="uk-flex uk-flex-left">
                        <div class="uk-margin-right">
                            <i class="fas fa-hourglass-end fa-lg in-icon-wrap primary-color"></i>
                        </div>
                        <div>
                            <h3>State of the art hardware</h3>
                            <p>All trades run on advanced server hardware at every level. The servers are also upgraded
                                annually to future-proof the growing demand.</p>
                        </div>
                    </div>
                    <div class="uk-flex uk-flex-left">
                        <div class="uk-margin-right">
                            <i class="fas fa-flag fa-lg in-icon-wrap primary-color"></i>
                        </div>
                        <div>
                            <h3>Fast Execution</h3>
                            <p>
                                Super fast interconnectivity, low latency and secure environment allow us to execute up
                                to 2,000 trades per second, each takes less than 1 millisecond.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- section content end -->
    <!-- section content begin -->
    <div class="uk-section uk-padding-remove-vertical uk-margin-medium-bottom">
        <div class="uk-container">
            <div class="uk-grid">
                <div class="uk-width-1-1">
                    <div class="uk-card uk-card-default uk-border-rounded uk-background-center uk-background-contain uk-background-image@m"
                        style="background-image: url({{ asset('frontend/img/in-team-background-1.png') }});"
                        data-uk-parallax="bgy: -100">
                        <div class="uk-card-body">
                            <div class="uk-grid uk-flex uk-flex-center">
                                <div class="uk-width-3-4@m uk-text-center">
                                    <h2>Our Company Profile</h2>
                                    <p style="text-align: justify;">{{ config('app.name') }} is an international
                                        brokerage house providing top quality financial and investment services all over
                                        the world. We have strong commitment in maintaining long term relationship with
                                        our clients and we strive to provide our clients with the very best service and
                                        the most competitive conditions in the industry. We are the a major provider of
                                        online foreign exchange (Forex) trading services, offering margin FX and
                                        commodities trading to individuals and institutional clients world-wide. Our
                                        multi-bank liquidity feed, fast execution and flexible leverage options set us
                                        apart as an industry leader. {{ config('app.name') }} delivers efficient
                                        services to all its clients. With a combination of straight-through processing
                                        (STP), non-dealing desk (NDD) execution, electronic communication networks (ECN)
                                        and stable high quality price feeds from the largest financial institutions,
                                        {{ config('app.name') }} is able to offer low-cost execution to clients, usually
                                        reserved only for banks and corporations. {{ config('app.name') }}'s primary
                                        belief is that the Forex market is not just for professional investors, traders
                                        or institutions; rather that the Forex market should be accessible to everybody.
                                        It has been {{ config('app.name') }}'s mission to both educate and guide
                                        individual investors while providing an unparalleled trading platform which
                                        traders can use effortlessly. By simplifying the process, educating investors
                                        and standing with them 24 hours a day. {{ config('app.name') }} has become the
                                        premier Forex Broker for every level of investor. With cutting edge trading
                                        platform and the ability to trade with ease from anywhere, via computer or
                                        mobile phone, trading is easier than ever before. {{ config('app.name') }}'s
                                        development team is always working to create new products designed to help
                                        investors make the most of their trading experiences. Through innovation,
                                        {{ config('app.name') }} is leading the way in currency trading.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- section content end -->
    <!-- section content begin -->
    <div class="uk-section in-counter-2">
        <div class="uk-container">
            <div class="uk-grid uk-flex uk-flex-center">
                <div class="uk-width-3-4@m">
                    <div class="uk-grid uk-flex uk-flex-middle" data-uk-grid>
                        <div class="uk-width-1-2@m">
                            <h4 class="uk-text-muted">Number speaks</h4>
                            <h1 class="uk-margin-medium-bottom">We always ready<br>for a challenge.</h1>
                            <a href="#" class="uk-button uk-button-primary uk-border-rounded">Learn more<i
                                    class="fas fa-arrow-circle-right uk-margin-small-left"></i></a>
                        </div>
                        <div class="uk-width-1-2@m">
                            <div class="uk-margin-large" data-uk-grid>
                                <div class="uk-width-1-3@m">
                                    <h1 class="uk-text-primary uk-text-right@m">
                                        <span class="count" data-counter-end="410">0</span>
                                    </h1>
                                    <hr class="uk-divider-small uk-text-right@m">
                                </div>
                                <div class="uk-width-expand@m">
                                    <h3>Progressively, together.</h3>
                                    <p style="text-align: justify;">Being in the financial markets, where everything
                                        moves rapidly, decisions after decisions are constantly being made. Our approach
                                        is to be rational, to make decisions that would move the company forward in a
                                        steadfast manner. We aim to progress further into the future, along with you,
                                        our customers - growing confidently together.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- section content end -->
</div>
