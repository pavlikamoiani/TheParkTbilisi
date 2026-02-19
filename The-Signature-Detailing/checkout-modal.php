<div id="checkoutModal" class="modal-overlay">
	<div class="modal-content">
		<button class="modal-close" id="closeModalBtn">&times;</button>
		<h2 style="margin-bottom:18px;">შეკვეთის ფორმა</h2>
		<form id="checkoutForm">
			<div class="form-group">
				<label for="customerName">სახელი/გვარი</label>
				<input type="text" id="customerName" name="customerName" required />
			</div>
			<div class="form-group">
				<label for="customerPhone">ტელეფონის ნომერი</label>
				<input type="tel" id="customerPhone" name="customerPhone" required />
			</div>
			<div class="form-group">
				<label for="customerAddress">მისამართი</label>
				<input type="text" id="customerAddress" name="customerAddress" required />
			</div>
			<div class="form-group">
				<label>თქვენი კალათა:</label>
				<div id="modalCartItems" class="modal-cart-items"></div>
			</div>
			<div class="form-group">
				<button type="submit" class="modal-submit">გაგზავნა</button>
			</div>
		</form>
	</div>
</div>
<script src="./js/checkout-modal.js"></script>