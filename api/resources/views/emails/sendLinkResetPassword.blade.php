<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:100,300,400,500,700,900">
    <title>Reset password in Schedulia</title>
    <style>
        div {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        h6 {
            font-family: Inter;
            font-style: normal;
            font-weight: bold;
            font-size: 20px;
            line-height: 32px;
            letter-spacing: 0.15px;
            color: #281ac8;
            display: inline-block;
            height: 100%;
            margin: 10px;
        }
        body {
            background-color: #e0e0e0;
        }
        main {
            width: 80%;
        }
    </style>

</head>
<body>
div>
<svg
        width="50"
        height="52"
        viewBox="0 0 50 52"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
>
    <circle cx="25.0001" cy="26.0001" r="24.3194" fill="white" />
    <mask
            id="mask0"
            mask-type="alpha"
            maskUnits="userSpaceOnUse"
            x="0"
            y="1"
            width="50"
            height="50"
    >
        <circle cx="25.0001" cy="26.0001" r="24.3194" fill="white" />
    </mask>
    <g mask="url(#mask0)">
        <rect
                x="-126.689"
                y="-276.967"
                width="573.792"
                height="371.944"
                rx="15.7361"
                fill="#FFD67A"
                stroke="#F0F0F0"
                stroke-width="2.86111"
        />
        <rect
                x="254.943"
                y="-448.403"
                width="570.931"
                height="369.083"
                rx="14.3056"
                transform="rotate(71.9185 254.943 -448.403)"
                fill="#FF8A7A"
                fill-opacity="0.6"
        />
        <rect
                x="-77.3037"
                y="-443.806"
                width="570.931"
                height="369.083"
                rx="14.3056"
                transform="rotate(27.0734 -77.3037 -443.806)"
                fill="#FF8A7A"
                fill-opacity="0.6"
        />
    </g>
    <path
            d="M29.2715 20.4615H34.3312C34.2581 16.0114 30.6004 12.9389 25.0407 12.9389C19.5664 12.9389 15.5552 15.9626 15.5796 20.4981C15.5674 24.1802 18.1643 26.2894 22.3828 27.3014L25.1017 27.9841C27.8206 28.6425 29.3324 29.4228 29.3446 31.1054C29.3324 32.9342 27.6011 34.1778 24.9188 34.1778C22.1756 34.1778 20.2004 32.9098 20.0297 30.4104H14.9212C15.0553 35.8116 18.9202 38.6036 24.9798 38.6036C31.0759 38.6036 34.6604 35.6896 34.6726 31.1175C34.6604 26.96 31.527 24.7532 27.1866 23.7778L24.9432 23.2414C22.773 22.7415 20.9564 21.9368 20.9929 20.1445C20.9929 18.5352 22.4194 17.3525 25.0042 17.3525C27.528 17.3525 29.0764 18.4986 29.2715 20.4615Z"
            fill="#281AC8"
    />
</svg>
<h6>Schedulia</h6>
</div>
<main>
    <p>Hello</p>
    <p>
        We’ve received a request to reset your password. If you didn’t make the
        request, just ignore this email. Otherwise, you can reset your password
        using this link:
    </p>
    <a href="{!!  $linkReset !!}" >Click here to reset your password</a>
    <p>This password reset link will expire in {{$count}} minutes.</p>
    <p>If link does not work please copy link below and paste in browser.</p>
    <p>{!! $linkReset!!}</p>
    <p>
        Thanks, <br />
        The Schedulia Team
    </p>
</main>
</body>
</html>
