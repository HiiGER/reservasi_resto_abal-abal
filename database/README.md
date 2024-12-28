# Dokumentasi SQL untuk `restaurant_reservation`

## Struktur Tabel

### Tabel `categories`

```sql
CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
```

### Tabel `customers`

```sql
CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `reservation_code` varchar(20) DEFAULT NULL,
  `table_number` int(11) DEFAULT NULL,
  `reservation_date` date DEFAULT NULL,
  `reservation_time` time DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
```

### Tabel `employees`

```sql
CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
```

### Tabel `reservations`

```sql
CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `reservation_date` date DEFAULT NULL,
  `reservation_time` time DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
```

## Data Awal (Dump)

### Data untuk Tabel `categories`

```sql
INSERT INTO `categories` (`id`, `name`, `created_at`) VALUES
(1, 'Appetizers', '2024-12-28 14:41:00'),
(2, 'Main Courses', '2024-12-28 14:41:00');
```

### Data untuk Tabel `customers`

```sql
INSERT INTO `customers` (`id`, `name`, `email`, `phone`, `reservation_code`, `table_number`, `reservation_date`, `reservation_time`, `created_at`) VALUES
(1, 'John Doe', 'john.doe@example.com', '1234567890', 'ABC123', 5, '2024-12-30', '19:00:00', '2024-12-28 14:41:00'),
(2, 'Jane Smith', 'jane.smith@example.com', '0987654321', 'XYZ456', 10, '2024-12-31', '20:00:00', '2024-12-28 14:41:00');
```

### Data untuk Tabel `employees`

```sql
INSERT INTO `employees` (`id`, `username`, `password`) VALUES
(1, 'admin', 'hashed_password_1'),
(2, 'staff', 'hashed_password_2');
```

### Data untuk Tabel `reservations`

```sql
INSERT INTO `reservations` (`id`, `customer_id`, `category_id`, `employee_id`, `reservation_date`, `reservation_time`, `created_at`) VALUES
(1, 1, 1, 2, '2024-12-30', '19:00:00', '2024-12-28 14:41:00'),
(2, 2, 2, 1, '2024-12-31', '20:00:00', '2024-12-28 14:41:00');
```

