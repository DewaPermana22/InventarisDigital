<style>
    body {
        font-family: 'Nunito', sans-serif;
        scroll-behavior: smooth;
    }

    /* Background gradient yang menyatu dari hero hingga footer */
    .continuous-gradient {
        background: linear-gradient(180deg,
                #f5f3ff 0%,
                #ffffff 15%,
                #ffffff 85%,
                #f5f3ff 100%);
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(139, 92, 246, 0.1);
    }

    .hero-blob {
        position: absolute;
        width: 600px;
        height: 600px;
        background: radial-gradient(circle, rgba(139, 92, 246, 0.15) 0%, rgba(255, 255, 255, 0) 70%);
        z-index: -1;
        border-radius: 50%;
    }

    /* Garis penghubung untuk cara kerja */
    .step-line::after {
        content: "";
        position: absolute;
        left: 1.25rem;
        /* Setengah dari w-10 */
        top: 2.5rem;
        bottom: -1.5rem;
        width: 2px;
        background: #e2e8f0;
        z-index: 0;
    }

    .step-item:last-child .step-line::after {
        display: none;
    }
</style>
