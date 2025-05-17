<div id="layoutAuthentication_footer">
    <footer class="glass-footer mt-auto">
        <div class="container-fluid px-4 text-center">
            <small class="footer-text">&copy; Notes Management System <?php echo date('Y'); ?></small>
        </div>
    </footer>
</div>

<style>
    .glass-footer {
        background: rgba(255, 255, 255, 0.2);
        /* brighter frosted glass */
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        padding: 1rem 0;
        border-top: 1px solid rgba(255, 255, 255, 0.4);
        position: relative;
        z-index: 10;
    }

    .footer-text {
        color: rgba(0, 0, 0, 0.8);
        /* darker text for visibility */
        font-weight: 500;
    }
</style>