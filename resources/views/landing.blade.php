<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inventaris Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f5f6f8;
        }
        .hero {
            padding: 200px 0;
            background: #fff;
        }
        .flow-card {
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            color: white;
        }

        .flow-card img {
            width: 60px;
            margin-bottom: 10px;
        }

        .footer {
            background: #fff;
            padding: 150px 0;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-light bg-white shadow-sm">
    <div class="container">
        <span class="navbar-brand mb-0 h6">SMK Wikrama</span>
        <a href="/login" class="btn"
                style="background-color: #1A1953; border: none; color: white;">
                Login
        </a>
    </div>
</nav>

<section class="hero text-center">
    <div class="container">
        <h3 class="fw-bold">Inventaris Management of<br>SMK Wikrama</h3>
        <p class="text-muted small">
            Management of incoming and outgoing inventory items at SMK Wikrama, Bogor
        </p>
    </div>
</section>

<section class="py-5">
    <div class="container text-center">
        <h5 class="fw-bold">Our system flow</h5>
        <p class="text-muted small">Our inventory system workflow</p>

        <div class="row mt-4 g-3">
            <div class="col-md-3">
                <div class="flow-card bg-dark">
                    <p class="small">Items Data</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="flow-card bg-warning text-dark">
                    <p class="small">Management Services</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="flow-card bg-info">
                    <p class="small">Managed Handling</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="flow-card bg-success">
                    <p class="small">All Can Borrow</p>
                </div>
            </div>

        </div>
    </div>
</section>

<footer class="footer ">
    <div class="container">
        <div class="row text-center text-md-start">

            <div class="col-md-4">
                <h6 class="fw-bold">SMK Wikrama</h6>
                <p class="small text-muted">Inventory App</p>
            </div>

            <div class="col-md-4">
                <h6 class="fw-bold">Our Guidelines</h6>
                <p class="small text-muted">Privacy Policy</p>
                <p class="small text-muted">Terms</p>
            </div>

            <div class="col-md-4">
                <h6 class="fw-bold">Our Address</h6>
                <p class="small text-muted">Bogor, Indonesia</p>
            </div>

        </div>
    </div>
</footer>

</body>
</html>


