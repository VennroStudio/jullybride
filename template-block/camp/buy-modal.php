<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<style>
    #buy-modal {
        position: fixed;
        inset: 0;
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .buy-modal-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, .6);
    }

    .buy-modal-box {
        position: relative;
        z-index: 1;
        width: 100%;
        max-width: 420px;
        padding: 40px;
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, .3);
    }

    .buy-modal-close {
        position: absolute;
        top: 16px;
        right: 16px;
        border: 0;
        background: none;
        color: #999;
        font-size: 20px;
        cursor: pointer;
    }

    .buy-modal-title {
        margin: 0 0 4px;
        font-size: 22px;
    }

    .buy-modal-subtitle {
        margin: 0 0 24px;
        color: #888;
        font-size: 14px;
    }

    .buy-modal-field {
        margin-bottom: 16px;
    }

    .buy-modal-field label {
        display: block;
        margin-bottom: 6px;
        font-size: 14px;
        font-weight: 600;
    }

    .buy-modal-field input {
        box-sizing: border-box;
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 15px;
    }

    .buy-modal-error {
        margin-bottom: 12px;
        color: #e53935;
        font-size: 13px;
    }

    .buy-modal-submit {
        width: 100%;
        margin-top: 8px;
    }
</style>

<div id="buy-modal" style="display:none;">
    <div class="buy-modal-overlay"></div>
    <div class="buy-modal-box">
        <button class="buy-modal-close" type="button" aria-label="Закрыть">x</button>
        <h3 class="buy-modal-title">Бронирование места</h3>
        <p class="buy-modal-subtitle" id="buy-modal-product-name"></p>
        <input type="hidden" id="buy-modal-product-id" value="">

        <div class="buy-modal-field">
            <label for="buy-name">Ваше имя</label>
            <input type="text" id="buy-name" placeholder="Имя Фамилия">
        </div>
        <div class="buy-modal-field">
            <label for="buy-email">Email</label>
            <input type="email" id="buy-email" placeholder="you@example.com">
        </div>

        <div class="buy-modal-error" id="buy-error" style="display:none;"></div>

        <button class="theme-button buy-modal-submit" id="buy-submit" type="button">
            Перейти к оплате
        </button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('buy-modal');
    if (!modal) return;

    document.addEventListener('click', function (event) {
        const button = event.target.closest('[data-action="buy-now"]');
        if (!button) return;

        event.preventDefault();
        document.getElementById('buy-modal-product-id').value = button.dataset.product || '';
        document.getElementById('buy-modal-product-name').textContent = button.dataset.productName || '';
        document.getElementById('buy-error').style.display = 'none';
        document.getElementById('buy-name').value = '';
        document.getElementById('buy-email').value = '';
        modal.style.display = 'flex';
    });

    modal.querySelector('.buy-modal-close').addEventListener('click', function () {
        modal.style.display = 'none';
    });

    modal.querySelector('.buy-modal-overlay').addEventListener('click', function () {
        modal.style.display = 'none';
    });

    document.getElementById('buy-submit').addEventListener('click', function () {
        const name = document.getElementById('buy-name').value.trim();
        const email = document.getElementById('buy-email').value.trim();
        const productId = document.getElementById('buy-modal-product-id').value;
        const errorEl = document.getElementById('buy-error');

        if (!name || !email) {
            errorEl.textContent = 'Пожалуйста, заполните все поля';
            errorEl.style.display = 'block';
            return;
        }

        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            errorEl.textContent = 'Введите корректный email';
            errorEl.style.display = 'block';
            return;
        }

        const button = document.getElementById('buy-submit');
        button.textContent = 'Создаем заказ...';
        button.disabled = true;

        fetch(window.jullybrideTheme?.ajaxUrl || '<?php echo esc_js(admin_url('admin-ajax.php')); ?>', {
            method: 'POST',
            body: new URLSearchParams({
                action: 'buy_now',
                product_id: productId,
                customer_name: name,
                customer_email: email
            })
        })
        .then(function (response) {
            return response.json();
        })
        .then(function (data) {
            if (data.success) {
                window.location.href = data.data.redirect;
                return;
            }

            errorEl.textContent = data.data || 'Ошибка, попробуйте снова';
            errorEl.style.display = 'block';
            button.textContent = 'Перейти к оплате';
            button.disabled = false;
        })
        .catch(function () {
            errorEl.textContent = 'Ошибка, попробуйте снова';
            errorEl.style.display = 'block';
            button.textContent = 'Перейти к оплате';
            button.disabled = false;
        });
    });
});
</script>
