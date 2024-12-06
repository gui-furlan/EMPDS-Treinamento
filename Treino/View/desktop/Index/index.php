<style>
    .root {
        box-sizing: border-box;
    }

    .progress-title {
        font-size: 1.7rem;
        font-weight: bold;
    }

    .index-nav {
        max-width: 100%;
        margin-top: 130px;
        margin-bottom: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-sizing: border-box;
    }

    .index-nav-list {
        width: 50%;
        display: flex;
        flex-wrap: wrap;
        flex: 1;
        align-items: center;
        justify-content: center;
        gap: 2rem;
        list-style: none;
        padding: 0;
        box-sizing: border-box;
    }

    .index-nav-item {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 16px 20px;
        box-sizing: border-box;
        border-radius: 6px;
        width: 300px;
        height: 140px;
        filter: drop-shadow(0px 2px 4px rgba(0, 0, 0, 0.25));
        margin-bottom: 20px;
    }

    .index-nav-link {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        gap: 20px;
    }

    .index-nav-item:hover {
        transform: scale(1.05);
        transition: all 0.3s ease-in-out;
        font-size: 1.1em;
    }

    .chart-container {
        width: 50%;
        height: 500px;
        margin: 0 auto;
        position: relative;
        display: grid;
        grid-template-columns: 1fr 1fr;
        align-items: center;
        justify-content: start;
        gap: 8rem;
        font-size: 2em !important;
    }
</style>
<div class="root">
    <h1>Hello World</h1>
</div>
<script>
    $(document).ready(() => {

    });
</script>