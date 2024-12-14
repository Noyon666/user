<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users List</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f6f9;
            color: #333;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #2c3e50;
            font-size: 2.5rem;
        }

        a {
            margin-bottom: 15px;
            text-decoration: none;
            background-color: #3498db;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            display: inline-block;
            transition: background-color 0.3s ease-in-out, transform 0.3s ease-in-out;
        }

        a:hover {
            background-color: hsl(208, 81%, 22%);
            transform: translateY(-3px);
        }

        .button {
            margin-top: 15px;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #ea745d;
            color: #ffffff;
            font-weight: Bold;
            transition: all 0.5s;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out, transform 0.3s ease-in-out;
        }

        .button:hover {
            background-color: #d52626;
            box-shadow: 0 0 20px #6fc5ff50;
            transform: scale(1.1);
        }

        .button.hidden {
            display: none;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 10px 15px rgba(0,0,0,0.1);
        }

        table th, table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #3498db;
            color: #fff;
            text-transform: uppercase;
            font-size: 14px;
        }

        table tbody tr {
            transition: background-color 0.3s ease-in-out;
        }

        table tbody tr:hover {
            background-color: #f1f1f1;
        }

        table tbody tr td a {
            color: #d5dfe7;
            font-weight: bold;
            transition: color 0.3s ease-in-out;
        }

        table tbody tr td a:hover {
            color: #cb3a27;
        }

        table tbody tr td input[type="checkbox"] {
            transform: scale(1.2);
            cursor: pointer;
            transition: transform 0.2s ease-in-out;
        }

        table tbody tr td input[type="checkbox"]:hover {
            transform: scale(1.4);
        }

        #selectAll {
            transform: scale(1.3);
            cursor: pointer;
        }

        #selectAll:hover {
            transform: scale(1.5);
        }

        .success-message {
            background-color: #2ecc71;
            color: #fff;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 5px;
            text-align: center;
            animation: fadeIn 0.5s ease-in-out;
        }

        .success-message.fade-out {
            animation: fadeOut 0.5s ease-in-out forwards;
        }

        .error-message {
            background-color: #e74c3c;
            color: #fff;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 5px;
            text-align: center;
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {opacity: 0; transform: translateY(-10px);}
            to {opacity: 1; transform: translateY(0);}
        }

        @keyframes fadeOut {
            from {opacity: 1; transform: translateY(0);}
            to {opacity: 0; transform: translateY(-10px);}
        }
    </style>
</head>
<body>
    <h1>Users List</h1>
    <a href="{{ url('users/create') }}">Add New User</a>
      

    @if(session('success'))
        <div class="success-message" id="successMessage">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="error-message">{{ session('error') }}</div>
    @endif

    <form action="{{ url('users/delete-selected') }}" method="post">
        @csrf

        <table>
            <thead>
                <tr>
                    <th><input type="checkbox" id="selectAll"></th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td><input type="checkbox" name="user_ids[]" value="{{ $user->id }}" class="user-checkbox"></td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->cphone }}</td>
                    <td>
                        <a href="{{ url('users/edit/'.$user->id) }}">Edit</a> |
                        <a href="{{ url('users/delete/'.$user->id) }}" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <button type="submit" class="button hidden" id="deleteSelectedButton" onclick="return confirm('Are you sure you want to delete the selected users?')">Delete Selected</button>
    </form>

    <script>
        const successMessage = document.getElementById('successMessage');
        const selectAllCheckbox = document.getElementById('selectAll');
        const userCheckboxes = document.querySelectorAll('.user-checkbox');
        const deleteButton = document.getElementById('deleteSelectedButton');

        // Auto-hide success message after 5 seconds
        if (successMessage) {
            setTimeout(() => {
                successMessage.classList.add('fade-out');
                successMessage.addEventListener('animationend', () => successMessage.remove());
            }, 5000); // 5000ms = 5 seconds
        }

        // Show or hide delete button based on selection
        function toggleDeleteButton() {
            const anyChecked = Array.from(userCheckboxes).some(checkbox => checkbox.checked);
            deleteButton.classList.toggle('hidden', !anyChecked);
        }

        // Listen for changes on the 'Select All' checkbox
        selectAllCheckbox.addEventListener('click', function(event) {
            userCheckboxes.forEach(checkbox => checkbox.checked = event.target.checked);
            toggleDeleteButton();
        });

        // Listen for changes on individual checkboxes
        userCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', toggleDeleteButton);
        });
    </script>
</body>
</html>
