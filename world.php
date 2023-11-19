<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
$stmt = $conn->query("SELECT * FROM countries");

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
$result = array();

// GET
$country = isset($_GET['country']) ? htmlspecialchars($_GET['country']) : '';
$city = isset($_GET['lookup']) && htmlspecialchars($_GET['lookup']) == 'cities';

if ($city) {
    $sql = "SELECT cities.name AS city_name, cities.district, cities.population
            FROM cities
            INNER JOIN countries ON cities.id = countries.capital
            WHERE countries.name LIKE :country";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':country', $country, PDO::PARAM_STR);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $sql = "SELECT * FROM countries WHERE name LIKE :country";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':country', $country, PDO::PARAM_STR);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>
<?php if (!$results && !$city): ?>
    <table>
        <thead>
            <tr>
                <th>Country</th>
                <th>Continent</th>
                <th>Independence</th>
                <th>Head of State</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $row): ?>
                <tr>
                    <td><?= $row['name']; ?></td>
                    <td><?= $row['continent']; ?></td>
                    <td><?= $row['independence_year']; ?></td>
                    <td><?= $row['head_of_state']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<!-- countries -->
<?php if ($results && !$city): ?>
    <?php if ($results): ?>
        <h2>Search Results for <?= $country ?>:</h2>
        <table id="countryTable">
            <thead>
                <th>Country</th>
                <th>Continent</th>
                <th>Independence</th>
                <th>Head of State</th>
            </thead>
            <tbody>
                <?php foreach ($result as $countryinfo): ?>
                    <tr>
                        <td><?= $countryinfo['name']; ?></td>
                        <td><?= $countryinfo['continent']; ?></td>
                        <td><?= $countryinfo['independence_year']; ?></td>
                        <td><?= $countryinfo['head_of_state']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No information found for <?= $country ?></p>
    <?php endif; ?>
<?php endif; ?>

<!-- cities -->
<?php if ($city): ?>
    <h2>Search Results for <?= $country ?>:</h2>
    <table id="cityTable">
        <thead>
            <th>Name</th>
            <th>District</th>
            <th>Population</th>
        </thead>
        <tbody>
            <?php foreach ($result as $cityinfo): ?>
                <tr>
                    <td><?= $cityinfo['city_name']; ?></td>
                    <td><?= $cityinfo['district']; ?></td>
                    <td><?= $cityinfo['population']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
