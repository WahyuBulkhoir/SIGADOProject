<!DOCTYPE html>
<html lang="en">

<head>
  @include('home.css')

  <style>
    .cart-container {
      margin-top: 60px;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    table {
      border-collapse: collapse;
      width: 80%;
      max-width: 900px;
      margin-bottom: 30px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    th, td {
      border: 1px solid skyblue;
      padding: 15px;
      text-align: center;
    }

    th {
      background-color: #343a40;
      color: white;
      font-size: 18px;
    }

    td img {
      width: 120px;
      height: auto;
      border-radius: 8px;
      object-fit: cover;
    }

    .total-value {
      font-size: 22px;
      font-weight: bold;
      margin-bottom: 20px;
    }

    .order-form {
      width: 100%;
      max-width: 600px;
      background-color: #f8f9fa;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .form-group {
      display: flex;
      flex-direction: column;
      margin-bottom: 15px;
    }

    .form-group label {
      margin-bottom: 5px;
      font-weight: 600;
    }

    .form-group input, 
    .form-group textarea {
      padding: 10px;
      border: 1px solid #ced4da;
      border-radius: 5px;
      width: 100%;
    }

    .form-actions {
      display: flex;
      justify-content: space-between;
      gap: 10px;
    }

    .empty-cart-message {
      font-size: 22px;
      font-weight: bold;
      color: #333;
      margin-top: 50px;
    }
  </style>
</head>

<body>
  <div class="hero_area">
    @include('home.header')
  </div>

  <div class="cart-container">
    @if($cart->isEmpty())
      <div class="empty-cart-message">Tidak ada produk di keranjang.</div>
    @else
      <table>
        <thead>
          <tr>
            <th>Product Title</th>
            <th>Price</th>
            <th>Image</th>
            <th>Remove</th>
          </tr>
        </thead>
        <tbody>
          <?php $value = 0; ?>
          @foreach($cart as $cartItem)
            <tr>
              <td style="color: #333;"><b>{{ $cartItem->product->title }}</b></td>
              <td style="color: #333;"><b>Rp. {{ number_format($cartItem->product->price, 0, ',', '.') }}</b></td>
              <td>
                <img src="/products/{{ $cartItem->product->image }}" alt="{{ $cartItem->product->title }}">
              </td>
              <td>
                <a class="btn btn-danger" href="{{ url('remove_cart', $cartItem->id) }}">Remove</a>
              </td>
            </tr>
            <?php $value += $cartItem->product->price; ?>
          @endforeach
        </tbody>
      </table>

      <div class="total-value" style="color: #333;">
        Nilai total di keranjang: Rp. {{ number_format($value, 0, ',', '.') }}
      </div>

      <div class="order-form">
        <form action="{{ url('confirm_order') }}" method="POST">
          @csrf

          <div class="form-group">
            <label for="name" style="color: #333;"><i>Nama Penerima</i></label>
            <input type="text" id="name" name="name" value="{{ Auth::user()->name }}" required>
          </div>

          <div class="form-group">
            <label for="address" style="color: #333;"><i>Alamat Lengkap Penerima</i></label>
            <textarea id="address" name="address" rows="3" required>{{ Auth::user()->address }}</textarea>
          </div>

          <div class="form-group">
            <label for="phone" style="color: #333;"><i>No. Handphone Penerima</i></label>
            <input type="text" id="phone" name="phone" value="{{ Auth::user()->phone }}" required>
          </div>

          <div class="form-actions">
            <button type="submit" class="btn btn-primary">Cash on Delivery</button>
            <a class="btn btn-success" href="{{ url('stripe', $value) }}">Bayar dengan Rekening</a>
          </div>
        </form>
      </div>
    @endif
  </div><br><br>

  @include('home.footer')
</body>

</html>