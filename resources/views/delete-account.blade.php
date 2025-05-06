    <h1 style="text-align: center;">Delete Account</h1>
    <form method="POST" action="">
    @csrf        
    <label>Entity Name:</label>
    <input type="text" name="entity_name" required><br>

    <label>Email:</label>
    <input type="email" name="email" required><br>

    <label>Phone:</label>
    <input type="text" name="phone" required><br>

    <label>Comments:</label>
    <textarea name="comments"></textarea><br>

    <button type="submit">Submit Request</button>
</form>