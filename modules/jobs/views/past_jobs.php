  <section class="main-sec">
      <div class="container cont-sm">
          <div class="container-header pb8">
              <h2>Search for Past Jobs</h2>
          </div>
          <div><input type="date" id="datePicker"></div>
          <div class="m8-block" id="day-choice">
              <input type="radio" id="day-pick" name="picked" value="day" checked>
                <label for="day-pick">Day (gets the day)</label><br>
              <input type="radio" id="week-pick" name="picked" value="week">
                <label for="week-pick">Week (gets the week)</label><br>
          </div>
          <div class="pt16">
              <a href="#" id="anchorTag" class="button btn-secondary">Look Up</a>
          </div>
      </div>
  </section>

  <script>
      const datePicker = document.getElementById('datePicker');
      const anchorTag = document.getElementById('anchorTag');

      anchorTag.addEventListener('click', function(event) {
          event.preventDefault();

          const selectedDate = datePicker.value;
          const checkedRadio = document.querySelector('input[name="picked"]:checked');
          let newHref = '';
          if (checkedRadio.value == 'day') {
               newHref = `<?= BASE_URL ?>jobs/day_view/${selectedDate}`;
          } else {
               newHref = `<?= BASE_URL ?>timesheets/display/one_week/${selectedDate}`;
          }
          anchorTag.href = newHref;
          window.location.href = anchorTag.href;
      });    
  </script>