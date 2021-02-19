<?php
/**
 * Connect to DB
 */
/** @var \PDO $pdo */
require_once './pdo_ini.php';

/**
 * SELECT the list of unique first letters using https://www.w3resource.com/mysql/string-functions/mysql-left-function.php
 * and https://www.w3resource.com/sql/select-statement/queries-with-distinct.php
 * and set the result to $uniqueFirstLetters variable
 */
$sth = $pdo->prepare('SELECT DISTINCT LEFT(name, 1) as letter  FROM airports');
$sth->setFetchMode(\PDO::FETCH_ASSOC);
$sth->execute();
$airports = $sth->fetchAll();

$uniqueFirstLetters = [];
foreach ($airports as $airport) {
    $uniqueFirstLetters[] = $airport['letter'];
}
sort($uniqueFirstLetters);

// Filtering
/**
 * Here you need to check $_GET request if it has any filtering
 * and apply filtering by First Airport Name Letter and/or Airport State
 * (see Filtering tasks 1 and 2 below)
 *
 * For filtering by first_letter use LIKE 'A%' in WHERE statement
 * For filtering by state you will need to JOIN states table and check if states.name = A
 * where A - requested filter value
 */
if (isset($_GET['filter_by_first_letter'])) {
    $sth = $pdo->prepare('SELECT A.name, A.code, S.name AS state, C.name AS city, A.address, A.timezone
                                FROM states S 
                                LEFT JOIN cities C ON S.id = C.state_id
                                LEFT JOIN airports A ON C.id = A.city_id 
                                WHERE A.name LIKE :letter OR S.name LIKE :letter');
    $sth->setFetchMode(\PDO::FETCH_ASSOC);
    $sth->execute(['letter' => "{$_GET['filter_by_first_letter']}%"]);
    $airports = $sth->fetchAll();
}
if (isset($_GET['filter_by_state'])) {
    $sth = $pdo->prepare('SELECT DISTINCT A.name, A.code, S.name AS state, C.name AS city, A.address, A.timezone
                                FROM states S 
                                LEFT JOIN cities C ON S.id = C.state_id
                                LEFT JOIN airports A ON C.id = A.city_id 
                                WHERE S.name =:state');
    $sth->setFetchMode(\PDO::FETCH_ASSOC);
    $sth->execute(['state' => $_GET['filter_by_state']]);
    $airports1 = $sth->fetchAll();
}

// Sorting
/**
 * Here you need to check $_GET request if it has sorting key
 * and apply sorting
 * (see Sorting task below)
 *
 * For sorting use ORDER BY A
 * where A - requested filter value
 */
if (isset($_GET['sort'])) {
    $sth = $pdo->prepare("SELECT A.name, A.code, S.name AS state, C.name AS city, A.address, A.timezone
                                FROM states S 
                                LEFT JOIN cities C ON S.id = C.state_id
                                LEFT JOIN airports A ON C.id = A.city_id ORDER BY :state");
    $sth->setFetchMode(\PDO::FETCH_ASSOC);
    $sth->execute(['state' => $_GET['sort']]);
    $airports = $sth->fetchAll();
}

// Pagination
/**
 * Here you need to check $_GET request if it has pagination key
 * and apply pagination logic
 * (see Pagination task below)
 *
 * For pagination use LIMIT
 * To get the number of all airports matched by filter use COUNT(*) in the SELECT statement with all filters applied
 */
if (isset($_GET['page'])) {
    $rowsPerPage = 5;
    $currentPage = (is_numeric($_GET['page'])) ? (int)$_GET['page'] : 1;
    $offset = ($currentPage - 1) * $rowsPerPage;

    $sql = 'SELECT A.name, A.code, S.name AS state, C.name AS city, A.address, A.timezone, COUNT(*) OVER() as total
                                FROM states S 
                                LEFT JOIN cities C ON S.id = C.state_id
                                LEFT JOIN airports A ON C.id = A.city_id';

    if (isset($_GET['filter_by_first_letter']) || isset($_GET['filter_by_state'])) {
        $sql = $sql . ' WHERE';
    }
    if (isset($_GET['filter_by_state'])) {
        $sql = $sql . ' S.name = :state';
    }
    if (isset($_GET['filter_by_first_letter']) && isset($_GET['filter_by_state'])) {
        $sql = $sql . ' OR';
    }
    if (isset($_GET['filter_by_first_letter'])) {
        $sql = $sql . ' A.name LIKE :letter';
    }
    $sql = $sql . " LIMIT :offset , :rowsPerPage";

    $sth = $pdo->prepare($sql);
    $sth->setFetchMode(\PDO::FETCH_ASSOC);
    $sth->bindParam(':offset', $offset, PDO::PARAM_INT);
    $sth->bindParam(':rowsPerPage', $rowsPerPage, PDO::PARAM_INT);
    if (isset($_GET['filter_by_first_letter'])) {
        $filter_by_first_letter = "{$_GET['filter_by_first_letter']}%";
        $sth->bindParam(':letter', $filter_by_first_letter, PDO::PARAM_STR);
    }
    if (isset($_GET['filter_by_state'])) {
        $sth->bindParam(':state', $_GET['filter_by_state'], PDO::PARAM_STR);
    }
    $sth->execute();
    $airports = $sth->fetchAll();
}

/**
 * Build a SELECT query to DB with all filters / sorting / pagination
 * and set the result to $airports variable
 *
 * For city_name and state_name fields you can use alias https://www.mysqltutorial.org/mysql-alias/
 */
$rowsPerPage = 5;
$currentPage = (isset($_GET['page']) && is_numeric($_GET['page'])) ? (int)$_GET['page'] : 1;
$offset = ($currentPage - 1) * $rowsPerPage;

$sql = 'SELECT A.name, A.code, S.name AS state, C.name AS city, A.address, A.timezone, COUNT(*) OVER() as total
                                FROM states S 
                                LEFT JOIN cities C ON S.id = C.state_id
                                LEFT JOIN airports A ON C.id = A.city_id';

if (isset($_GET['filter_by_first_letter']) || isset($_GET['filter_by_state'])) {
    $sql = $sql . ' WHERE';
}
if (isset($_GET['filter_by_state'])) {
    $sql = $sql . ' S.name = :state';
}
if (isset($_GET['filter_by_first_letter']) && isset($_GET['filter_by_state'])) {
    $sql = $sql . ' OR';
}
if (isset($_GET['filter_by_first_letter'])) {
    $sql = $sql . ' A.name LIKE :letter';
}
if (isset($_GET['sort'])) {
    $sql = $sql . ' ORDER BY :state';
}
$sql = $sql . ' LIMIT :offset , :rowsPerPage';

$sth = $pdo->prepare($sql);
$sth->setFetchMode(\PDO::FETCH_ASSOC);
$sth->bindParam(':offset', $offset, PDO::PARAM_INT);
$sth->bindParam(':rowsPerPage', $rowsPerPage, PDO::PARAM_INT);
if (isset($_GET['filter_by_first_letter'])) {
    $filter_by_first_letter = "{$_GET['filter_by_first_letter']}%";
    $sth->bindParam(':letter', $filter_by_first_letter, PDO::PARAM_STR);
}
if (isset($_GET['filter_by_state'])) {
    $sth->bindParam(':state', $_GET['filter_by_state'], PDO::PARAM_STR);
}
if (isset($_GET['sort'])) {
    $sth->bindParam(':state', $_GET['sort'], PDO::PARAM_STR);
}
$sth->execute();
$airports = $sth->fetchAll();

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title>Airports</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
          integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <style>
        .pagination {
            flex-wrap: wrap;
        }
    </style>
</head>
<body>

<main role="main" class="container">
    <h1 class="mt-5">US Airports</h1>
    <div class="alert alert-dark">
        Filter by first letter:
        <?php foreach ($uniqueFirstLetters as $letter) : ?>
            <a href="<?= targetPage('filter_by_first_letter', $letter, true); ?>"><?= $letter ?></a>

        <?php endforeach; ?>
        <a href="/" class="float-right">Reset all filters</a>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th scope="col"><a href="<?= targetPage('sort', 'name'); ?>">Name</a></th>
            <th scope="col"><a href="<?= targetPage('sort', 'code'); ?>">Code</a></th>
            <th scope="col"><a href="<?= targetPage('sort', 'state'); ?>">State</a></th>
            <th scope="col"><a href="<?= targetPage('sort', 'city'); ?>">City</a></th>
            <th scope="col">Address</th>
            <th scope="col">Timezone</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($airports as $airport) : ?>
            <tr>
                <td><?= $airport['name'] ?></td>
                <td><?= $airport['code'] ?></td>
                <td>
                    <a href="<?= targetPage('filter_by_state', $airport['state'], true); ?>">
                        <?= $airport['state'] ?></a>
                </td>
                <td><?= $airport['city'] ?></td>
                <td><?= $airport['address'] ?></td>
                <td><?= $airport['timezone'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <nav aria-label="Navigation">
        <ul class="pagination justify-content-center">

            <?php

            /**
             * Makes result URL
             * @param string $parameter
             * @param string|integer $value
             * @param boolean $firstPageRedirect
             * @return string
             */
            function targetPage($parameter, $value, $firstPageRedirect = false): string
            {
                list($link, $parameters) = explode('?', $_SERVER['REQUEST_URI']);

                parse_str($parameters, $output);
                unset($output[$parameter]);
                if ($firstPageRedirect) {
                    unset($output['page']);
                    return str_replace("?&", "?", $link . '?' . http_build_query($output) . '&' .
                        $parameter . '=' . $value . '&page=1');
                }
                return str_replace("?&", "?", $link . '?' . http_build_query($output) . '&' .
                    $parameter . '=' . $value);
            }

            for ($i = 1; $i <= ceil($airports[0]['total'] / $rowsPerPage); $i++) {
                if ($i == $currentPage) { ?>
                    <li class='page-item active'><a class='page-link'
                                                    href='<?= targetPage('page', $i) ?>'><?= $i ?></a>
                    </li>
                <?php } else { ?>
                    <li class='page-item '><a class='page-link'
                                              href='<?= targetPage('page', $i) ?>'><?= $i ?></a>
                    </li>
                <?php }
            }
            ?>
        </ul>
    </nav>
</main>
</html>