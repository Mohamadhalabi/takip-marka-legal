<footer class="footer bg-white shadow align-self-end py-3 px-xl-5 w-100">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-6 text-center text-md-start">
          <p class="mb-2 mb-md-0 fw-bold">{{ env('APP_TITLE') }} &copy; {{ date('Y') }}</p>
            <p class="mb-2 mb-md-0 fw-bold">{{ env('APP_NAME') }}</p>
        </div>
        <div class="col-md-6 text-center text-md-end text-gray-400">
          <p class="mb-0">{{ __('theme/footer.version',['version' => '1.0.0']) }}</p>
        </div>
      </div>
    </div>
</footer>
