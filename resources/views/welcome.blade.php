<x-guest-layout>
<div class="flex min-h-full items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
  <div class="w-full max-w-md space-y-8">
    <div>
      <img class="mx-auto h-12 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company">
      <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-gray-900">Enter your email address to get your OTP</h2>
      <p class="mt-2 text-center text-sm text-gray-600">
        Or
        <a href="{{route('verify_otp_view')}}" class="font-medium text-indigo-600 hover:text-indigo-500">verify if its valid if you received one</a>
      </p>
    </div>
    <form class="mt-8 space-y-6" action="{{route('sendOtp')}}" method="POST">
        @csrf
      <input type="hidden" name="remember" value="true">
      <div class="-space-y-px rounded-md shadow-sm">
        <div>
          <label for="email-address" class="sr-only">Email address</label>
          <input id="email-address" name="email" type="email" autocomplete="email" required class="relative block w-full appearance-none rounded-none rounded-t-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm" placeholder="Email address">
        </div>
      </div>

        <button type="submit" class="group relative flex w-full justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
          <span class="absolute inset-y-0 left-0 flex items-center pl-3">
          </span>
          @if(count($_COOKIE) > 2)
            Resend OTP
          @else
            Send OTP
          @endif
        </button>
      </div>
    </form>
  </div>
</div>

</x-guest-layout>

