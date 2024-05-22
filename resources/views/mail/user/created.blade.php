<x-mail::message>
<div style="text-align: center; margin-bottom: 20px; display: block">
    <img src="{{  asset('images/7626666.png')  }}" alt="Congratulations" style="width: 150px">
</div>

<h2 class="text-center font-lg text-black">Welcome to MAREN CRM</h2>

<p style="text-align: center">
    Hi {{ $user->name  }}! A new account for MAREN CRM system has been created for you. Login to your account with credentials listed below
</p>

<x-mail::button :url="route('login')" color="success">
Log In To Your Account
</x-mail::button>

<div style="text-align: center"><span style="font-weight: bold" >Email :</span> {{ $user->email  }}</div>
<p style="text-align: center"><span style="font-weight: bold" >Password :</span> {{ $password  }}</p>

<p class="text-center">Thanks</p><br>

</x-mail::message>
<script>
    import InputGroup from "@/Components/Form/BaseInputGroup.vue";
    export default {
        components: {InputGroup}
    }
</script>
