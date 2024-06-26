<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    @include('layouts.frontend.partials.css')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('layouts.frontend.partials.js')
    @yield('styles')
</head>

<body id="transcroller-body" class="aos-all">



    @include('layouts.frontend.partials.header')
    


    @yield('content')
    <div class="spacer"></div>

    @include('layouts.frontend.partials.footer')



    <!-- The subscribe modal popup -->
    <div id="subscribeModal" class="modal subscribe_popup">
        <div class="modal-content">
            <h2>Subscribe</h2>
            <p>Please submit the form below to process.</p>
            <form id="subscribe_form">
                <input name="name" type="text" required name="" placeholder="Full Name">
                <input name="email" type="email" required name="" placeholder="Email Address">
                <select name="provice" required>
                    <option slected disabled>Select Provice</option>
                    <option>Kabul</option>
                    <option>Takhar</option>
                    <option>Helmand</option>
                </select>
                <select name="district" required>
                    <option slected disabled>Select District</option>
                    <option>Something</option>
                    <option>asdfasd</option>
                    <option>Testing this</option>
                </select>
                <input class="btn btn-primary" type="submit" value="Subscribe">
            </form>
        </div>
    </div>



    
</body>
@yield('scripts')
    <script type="text/javascript">
         var site_url = "{{ config('app.app_url') }}";
        // Check if the user has visited before
        function hasVisitedBefore() {
            return (localStorage.getItem('visited') === 'true');
        }

        // Set visited flag to true
        function setVisited() {
            localStorage.setItem('visited', 'true');
        }

        // Show the modal popup after a delay
        function showModalWithDelay() {
            setTimeout(function() {
                $("#subscribeModal").show();
            }, 3000); // 3-second delay
        }

        // Hide the modal popup
        function hideModal() {
            $("#subscribeModal").hide();
        }

        // Function to be executed when the form is submitted
        function formSubmitted(event) {
            event.preventDefault();
            setVisited();
            hideModal();
        }

        // Check if the user has visited before
        //if (!hasVisitedBefore()) {
         //   $(window).on("load", showModalWithDelay);
        // }

        // Add event listener to form submission
        $("#subscribe_form").on("submit", formSubmitted);

        // Add event listener to close button
        $(".close").on("click", hideModal);
    </script>
</html>
