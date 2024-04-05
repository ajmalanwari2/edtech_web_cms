@if ($message = Session::pull('success'))
     <!-- Toast with Animation -->
     <div id="toast-container">
        <div class="toast toast-success" aria-live="polite" style="opacity: 0.881;">
            <div class="toast-progress" style="width: 0%;"></div>
            <div class="toast-title">Well Done!</div>
            <div class="toast-message">{{ $message}}</div>
        </div>
    </div>
 @endif
 <!--/ Toast with Animation -->

 @if ($message = Session::pull('error'))
     <!-- Toast with Animation -->
     <div class="toast toast-success" id="toast-container"
          role="alert" aria-live="polite" aria-atomic="true" data-bs-delay="2000">
         <div class="toast-message">{{ $message }}</div>
     </div>
 @endif
 <!--/ Toast with Animation -->


 
 @section('scripts')
     <script>
         $('#toast-container').delay(2000).fadeOut(400);
     </script>
 @endsection
