GET /api/guides
Параметр запроса: min_experience?=int
200:
{
  "data": [{ "id": 1, "name": "John Doe", "experience_years": 5 }],
  
  "meta": { "min_experience": 3 }
}


POST /api/bookings
Тело запроса:

{
  "tour_name": "Boar Run",
  
  "hunter_name": "John Doe",
  "guide_id": 1,
  "date": "2025-11-10",
  "participants_count": 4
}

201:
{
  "id": 1,
  "tour_name": "Boar Run",
  
  "hunter_name": "John Doe",
  "date": "2025-11-10",
  "participants_count": 4,
  "guide": { "id": 1, "name": "John Doe", "experience_years": 5 }
}

409:
{ "message": "Гид недоступен на выбранную дату." }




