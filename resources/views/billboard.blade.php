<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="refresh" content="60">
  <title>Digital Billboard</title>

  <style>
    body, html {
      margin: 0;
      padding: 0;
      height: 100%;
      width: 100%;
      overflow: hidden;
      background: black;
    }

    .slide-container {
      position: relative;
      height: 100%;
      width: 100%;
    }

    .slide {
      position: absolute;
      height: 100%;
      width: 100%;
      background-size: cover;
      background-position: center;
      opacity: 0;
      transition: opacity 1s ease-in-out;
    }

    .active {
      opacity: 1;
    }
  </style>
</head>
<body>

<div class="slide-container">
    @foreach($images as $index => $image)
        <div 
            class="slide {{ $index === 0 ? 'active' : '' }}" 
            style="background-image: url('/images/{{ $image->name }}');">
        </div>
    @endforeach
</div>

<script>
    let index = 0;
    const slides = document.querySelectorAll(".slide");
    setInterval(() => {
      slides[index].classList.remove("active");
      index = (index + 1) % slides.length;
      slides[index].classList.add("active");
    }, 6000); // Change slide every 6 seconds
  </script>
</body>
</html>