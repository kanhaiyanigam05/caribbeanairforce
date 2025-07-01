@extends('layout.email')
@push('css')
    {{--  --}}
@endpush
@section('email')
    <div class="container py-5">
        <div class="row">
            <div class="col-12">
                <form action="{{ route('admin.email.compose.send') }}" method="post" id="compose-mail">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="text" name="to" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Subject</label>
                        <input type="text" name="subject" class="form-control" id="subject" name="subject" required>
                    </div>
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea name="body" class="form-control" id="message" name="message" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <div class="container py-5">
        <div class="row">
            <div class="col-12">
                <h2>Recent Emails</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>From</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="mail-status">
                        {{--  --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            $('#compose-mail').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                $.ajax({
                    url: form.attr('action'),
                    method: form.attr('method'),
                    data: form.serialize(),
                    success: function(response) {
                        console.log(response);
                        alert('Email sent successfully!');
                        form[0].reset();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', xhr, status, error);
                        alert('Failed to send email. Please try again.');
                    }
                });
            });
        });
        // Pusher.logToConsole = true;

        // var pusher = new Pusher("39539b20dded4713af2a", {
        //     cluster: "ap2",
        //     forceTLS: true
        // });

        // var channel = pusher.subscribe("emailing");

        // channel.bind("MailEvent", function(data) {

        //     // Ensure the tbody element exists
        //     const tbody = $('#mail-status');

        //     // Create a new row with data received
        //     const row = `<tr>
    //         <td>${data.to}</td>
    //         <td>${data.status}</td>
    //     </tr>`;

        //     // Append the row to the tbody
        //     tbody.append(row);
        //     console.log(data);
        // });
    </script>
    @vite(['resources/js/app.js'])
@endpush
