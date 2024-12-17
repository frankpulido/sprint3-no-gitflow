<?php
$taskController = new TaskController();
//$taskController->execute('create');  // Debugging... This method is supposed to call createAction and render the appropriate view
?>

<header class="rajdhani-regular">
<section class="header-container">

    <section class="rajdhani-light">
        <nav class="views-menu">
            <a href="<?php echo WEB_ROOT; ?>/grid" class="menu-option" style="background-color: aliceblue;">GRID ALL VIEW</a> <!-- ELIMINATE STYLE WHEN ALL OPTIONS ARE ACTIVE -->
            <a href="<?php echo WEB_ROOT; ?>/kind" class="menu-option" style="background-color: aliceblue;">BY TASK KIND VIEW</a> <!-- ELIMINATE STYLE WHEN ALL OPTIONS ARE ACTIVE -->
            <a href="<?php echo WEB_ROOT; ?>/progress" class="menu-option" style="background-color: aliceblue;">BY TASK PROGRESS VIEW</a> <!-- ELIMINATE STYLE WHEN ALL OPTIONS ARE ACTIVE -->
        </nav>
    </section>

    <section class="rajdhani-light">
        <nav class="menu">
            <a href="#" class="menu-option">[ NEW PROJECT ]</a>
            <a href="javascript:void(0);" class="menu-option" style="background-color: aliceblue;" onclick="loadIframe('create_task')">[ NEW TASK ]</a> <!-- ELIMINATE STYLE WHEN ALL OPTIONS ARE ACTIVE -->
            <a href="#" class="menu-option">[ NEW PROGRAMMER ]</a>
        </nav>
        <nav class="menu">
            <a href="#" class="menu-option">[ SEARCH->UPDATE/DELETE PROJECT ]</a>
            <a href="javascript:void(0);" class="menu-option" style="background-color: aliceblue;" onclick="loadIframe('search_update_delete_task')">[ SEARCH->UPDATE/DELETE TASK ]</a> <!-- ELIMINATE STYLE WHEN ALL OPTIONS ARE ACTIVE -->
            <a href="#" class="menu-option">[ SEARCH->UPDATE/DELETE PROGRAMMER ]</a>
        </nav>
        <nav class="menu">
            <a href="#" class="menu-option">[ FILTER BY PROJECT STATUS ]</a>
            <a href="#" class="menu-option">[ FILTER BY PROJECT MANAGER ]</a>
            <a href="#" class="menu-option">[ FILTER BY DEVELOPER ]</a>
        </nav>
    </section>
    <section class="iframe-container">
        <p>[ CRUD IS DISPLAYED BELOW - ONLY OPTIONS WITH MATCHING COLOUR ARE ACTIVE ]</p>
        <iframe style="border: none;" id="crudIframe" src=""><p>Here goes the iFrame for the CRUD methods of class TaskManager</p></iframe>
    </section>
</section>
</header>

<script>
    function loadIframe(action) {
        let iframe = document.getElementById("crudIframe");
        switch(action) {
            case 'create_task':
                iframe.src = "<?php echo WEB_ROOT; ?>/task/create"; // NEW TASK
                //iframe.src = "/developers_nivel1/app/views/scripts/create.php"; // NEW TASK - Moving create.php to folder scripts didn't solved fatal error
                break;
            case 'create_project':
                iframe.src = "";  // new project (future development)
                break;
            case 'create_programmer':
                iframe.src = "";  // new programmer (future development)
                break;
            case 'search_update_delete_task':
                iframe.src = "<?php echo WEB_ROOT; ?>/task/show";  // SEARCH->UPDATE/DELETE TASK (UPDATE/DELETE are triggered within SEARCH)
                break;
            case 'search_update_delete_project':
                iframe.src = "";  // search/update/delete project (future development)
                break;
            case 'search_update_delete_programmer':
                iframe.src = "";  // search/update/delete programmer (future development)
                break;
            default:
                iframe.src = "";
                break;
        }
    // Ensure iframe resizes after loading
    iframe.onload = resizeIframe;
    }
    // Function to resize iframe
    function resizeIframe() {
        let iframe = document.getElementById("crudIframe");
        iframe.style.height = iframe.contentWindow.document.body.scrollHeight + "px";
    }
</script>