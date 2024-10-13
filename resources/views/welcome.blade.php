@extends('Admin.Layout.layout')

@section('title', 'Sonali Structure')

@section('page-heading')
Welcome @if(Auth::check()) {{ Auth::user()->name }} @else <p>Please log in.</p> @endif 🎉
@endsection

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row mb-4">
    <div class="col-3">
      <a href="{{ route('employees') }}" class="card">
        <div class="card-body">
          <div class="card-title d-flex align-items-start justify-content-between">
            <div class="avatar flex-shrink-0">
              <img
                src="../assets/img/icons/unicons/chart-success.png"
                alt="chart success"
                class="rounded" />
            </div>
            <!-- <div class="dropdown">
              <button
                class="btn p-0"
                type="button"
                id="cardOpt3"
                data-bs-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false">
                <i class="bx bx-dots-vertical-rounded"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                <a class="dropdown-item" href="{{ route('employees') }}">View More</a>
              </div>
            </div> -->
          </div>
          <span class="fw-semibold d-block mb-1">Total Employee</span>
          <h3 class="card-title mb-2">{{ $totalEmployees }}</h3>
        </div>
      </a>
    </div>
    <div class="col-3">
      <a href="{{ route('contracters') }}" class="card">
        <div class="card-body">
          <div class="card-title d-flex align-items-start justify-content-between">
            <div class="avatar flex-shrink-0">
              <img
                src="../assets/img/icons/unicons/chart-success.png"
                alt="chart success"
                class="rounded" />
            </div>
            <!-- <div class="dropdown">
              <button
                class="btn p-0"
                type="button"
                id="cardOpt3"
                data-bs-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false">
                <i class="bx bx-dots-vertical-rounded"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                <a class="dropdown-item" href="{{ route('contracters') }}">View More</a>
              </div>
            </div> -->
          </div>
          <span class="fw-semibold d-block mb-1">Total Contactor</span>
          <h3 class="card-title mb-2">{{ $totalContractors }}</h3>
        </div>
      </a>
    </div>
    <div class="col-3">
      <div class="card">
        <div class="card-body">
          <div class="card-title d-flex align-items-start justify-content-between">
            <div class="avatar flex-shrink-0">
              <img
                src="../assets/img/icons/unicons/chart-success.png"
                alt="chart success"
                class="rounded" />
            </div>
            <!-- <div class="dropdown">
              <button
                class="btn p-0"
                type="button"
                id="cardOpt3"
                data-bs-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false">
                <i class="bx bx-dots-vertical-rounded"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                <a class="dropdown-item" href="javascript:void(0);">View More</a>
                <a class="dropdown-item" href="javascript:void(0);">Delete</a>
              </div>
            </div> -->
          </div>
          <span class="fw-semibold d-block mb-1">Total Monthly Expense</span>
          <h3 class="card-title mb-2">₹ {{ $totalMonthlyExpense }}</h3>
        </div>
      </div>
    </div>
    <div class="col-3">
      <div class="card">
        <div class="card-body">
          <div class="card-title d-flex align-items-start justify-content-between">
            <div class="avatar flex-shrink-0">
              <img
                src="../assets/img/icons/unicons/chart-success.png"
                alt="chart success"
                class="rounded" />
            </div>
            <!-- <div class="dropdown">
              <button
                class="btn p-0"
                type="button"
                id="cardOpt3"
                data-bs-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false">
                <i class="bx bx-dots-vertical-rounded"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                <a class="dropdown-item" href="javascript:void(0);">View More</a>
                <a class="dropdown-item" href="javascript:void(0);">Delete</a>
              </div>
            </div> -->
          </div>
          <span class="fw-semibold d-block mb-1">Today's Expense</span>
          <h3 class="card-title mb-2">₹ {{ $todayExpenseamm }}</h3>
        </div>
      </div>
    </div>
  </div>
  <div class="row mb-4">
    <div class="col-6">
      <div class="card">
        <canvas id="expensesChart" width="400" height="200"></canvas>
      </div>
    </div>
    <div class="col-6">
      <div class="card">
        <canvas id="weekly_expensesChart" width="400" height="200"></canvas>
      </div>
    </div>
  </div>

  <!-- Table -->
  <div class="card mb-4">
    <h5 class="card-header">Today's Expenses</h5>
    <div class="table-responsive text-nowrap">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Title</th>
            <th>Date</th>
            <th>Amount</th>
            <th>Category</th>
            <th>Mode</th>
            <th>Bank Name</th>
            <th>Narration</th>
          </tr>
        </thead>


        <tbody class="table-border-bottom-0">
          @forelse($todayExpenses as $expense)
          <tr>
            <td><strong>{{ $expense->title }}</strong></td> <!-- Make sure this field exists -->
            <td>{{ $expense->date }}</td>
            <td>{{ $expense->amount }}</td>
            <td>{{ $expense->category->title ?? 'N/A' }}</td> <!-- Assuming a category relationship -->
            <td>{{ $expense->mode }}</td>
            <td>{{ $expense->bank_name }}</td>
            <td>{{ $expense->narration }}</td>
          </tr>
          @empty
          <tr>
            <td colspan="7">No expenses for today.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
  <div class="card">
    <h5 class="card-header">Today's Expenses</h5>
    <div class="table-responsive text-nowrap">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Date</th>
            <th>Ammount</th>
            <th>Pay Mode</th>
            <th>Status</th>
            <th>Narration</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          @forelse($weeklyExpenses as $expense)
          <tr>
            <td>{{ $expense->date }}</td>
            <td>{{ $expense->amount }}</td>
            <td>{{ $expense->mode }}</td>
            <td>{{ $expense->status }}</td>
            <td>{{ $expense->narration }}</td> 
          </tr>
          @empty
          <tr>
            <td colspan="5">No weekly expenses for this month.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
  <!-- / Table -->

</div>

<!-- graph scripts -->

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Fetch data via AJAX
    $.ajax({
      url: "{{ route('expenses.data') }}", // Route to fetch data
      type: 'GET',
      success: function(response) {
        // Initialize the months array with 12 months (from January to December)
        var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        var expenses = new Array(12).fill(0); // Start with all months having 0 expenses

        // Fill the expenses array with data for the corresponding month
        Object.keys(response).forEach(function(month) {
          // In JavaScript, months are zero-indexed, so we subtract 1 from the month value
          expenses[month - 1] = response[month];
        });

        // Create the chart
        var ctx = document.getElementById('expensesChart').getContext('2d');
        var expensesChart = new Chart(ctx, {
          type: 'bar', // You can use 'line', 'pie', etc.
          data: {
            labels: months, // Month labels
            datasets: [{
              label: 'Expenses',
              data: expenses, // The expense data fetched from the server
              backgroundColor: 'rgba(54, 162, 235, 0.2)',
              borderColor: 'rgba(54, 162, 235, 1)',
              borderWidth: 1
            }]
          },
          options: {
            scales: {
              y: {
                beginAtZero: true // Ensure the y-axis starts at zero
              }
            }
          }
        });
      },
      error: function(xhr, status, error) {
        console.error('Error fetching expense data:', error);
      }
    });
  });
</script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Fetch data via AJAX
    $.ajax({
      url: "{{ route('weekly.expenses.data') }}", // Route to fetch data
      type: 'GET',
      success: function(response) {
        // Initialize the months array with 12 months (from January to December)
        var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        var expenses = new Array(12).fill(0); // Start with all months having 0 expenses

        // Fill the expenses array with data for the corresponding month
        Object.keys(response).forEach(function(month) {
          // In JavaScript, months are zero-indexed, so we subtract 1 from the month value
          expenses[month - 1] = response[month];
        });

        // Create the chart
        var ctx = document.getElementById('weekly_expensesChart').getContext('2d');
        var expensesChart = new Chart(ctx, {
          type: 'bar', // You can use 'line', 'pie', etc.
          data: {
            labels: months, // Month labels
            datasets: [{
              label: 'Weekly Expenses',
              data: expenses, // The expense data fetched from the server
              backgroundColor: 'rgba(255, 99, 132, 0.2)', // Light reddish background
              borderColor: 'rgba(255, 99, 132, 1)', // Solid reddish border

              borderWidth: 1
            }]
          },
          options: {
            scales: {
              y: {
                beginAtZero: true // Ensure the y-axis starts at zero
              }
            }
          }
        });
      },
      error: function(xhr, status, error) {
        console.error('Error fetching expense data:', error);
      }
    });
  });
</script>

<!-- / graph scripts -->

@endsection