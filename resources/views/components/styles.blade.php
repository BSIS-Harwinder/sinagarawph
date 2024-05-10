<style>
    * {
        font-family: 'Roboto', sans-serif;
    }
    body{
        background: whitesmoke;
    }

    .section-padding{
        padding:100px 0;

    }

    .carousel-item{
        height: 100vh;
        min-height: 300px;
    }

    .carousel-caption{
        bottom:150px;
        z-index: 2;

    }

    .carousel-caption h5{
        font-size: 45px;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-top: 25px;
    }

    .carousel-caption p{
        width: 60%;
        margin: auto;
        font-size: 18px;
        line-height: 1.9;
    }

    .carousel-inner::before{
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        background: rgba(0, 0, 0, 0.7);
        z-index: 1;
    }

    .navbar-nav a{
        font-size: 15px;
        text-transform: uppercase;
        font-weight: 700;
    }

    .navbar-brand img{
        width: 150px
    }

    .w-100{
        height: 100vh;
    }

    .services .card-body i{
        font-size: 50px;
    }

    .card-body .lead{
        font-size: 15px;

    }

    .about-img img{
        margin-top: 50px;
    }
    /* responsive css */
    @media only screen and (max-width:767px){
        .navbar-nav{
            text-align: center;
        }

        .carousel-caption{
            bottom: 125px;
        }

        .carousel-caption h5{
            font-size: 17px;
        }

        .carousel-caption a{
            padding: 10px 15px;
        }

        .carousel-caption p{
            width: 100%;
            line-height: 1.6;
            font-size: 12px;
        }

        .carousel-caption{
            bottom:180px;
            z-index: 2;
        }

        .about-img img{
            margin-top: 0;
        }

        .card{
            margin-bottom: 30px;
        }

        .about-text{
            padding-top: 50px;
        }

    }
</style>
