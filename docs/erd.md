# ERD — Helpdesk & Ticketing System

```mermaid
erDiagram
    users ||--o{ tickets : "creates (customer_id)"
    users ||--o{ tickets : "assigned (assigned_to)"
    categories ||--o{ tickets : has
    priorities ||--o{ tickets : has
    tickets ||--o{ ticket_comments : has
    tickets ||--o{ ticket_attachments : has
    tickets ||--o{ activity_logs : has
    users ||--o{ ticket_comments : writes
    users ||--o{ activity_logs : performs

    users {
        bigint id PK
        string name
        string email UK
        string password
        timestamp email_verified_at
    }
    priorities {
        bigint id PK
        string name
        string slug UK
        tinyint level
        int first_response_minutes
        int resolution_minutes
        string color
    }
    categories {
        bigint id PK
        string name
        string slug UK
        text description
    }
    tickets {
        bigint id PK
        string ticket_number UK
        string subject
        text description
        bigint customer_id FK
        bigint assigned_to FK
        bigint category_id FK
        bigint priority_id FK
        string status
        timestamp first_response_due_at
        timestamp resolution_due_at
        timestamp first_responded_at
        timestamp resolved_at
        timestamp closed_at
        boolean sla_breached
    }
    ticket_comments {
        bigint id PK
        bigint ticket_id FK
        bigint user_id FK
        text body
        boolean is_internal
    }
    ticket_attachments {
        bigint id PK
        bigint ticket_id FK
        bigint comment_id FK
        bigint uploaded_by FK
        string original_name
        string path
        string mime_type
        bigint size
    }
    activity_logs {
        bigint id PK
        bigint ticket_id FK
        bigint user_id FK
        string action
        text description
        jsonb properties
    }
```

## Keterangan Role
- **Admin:** akses penuh, assign tiket, lihat semua tiket & dashboard
- **Agent:** lihat & kelola tiket yang di-assign, tulis catatan internal
- **Customer:** buat tiket baru, lihat & balas tiket miliknya sendiri

## Keterangan Status Tiket
`open` → `in_progress` → `resolved` → `closed`
