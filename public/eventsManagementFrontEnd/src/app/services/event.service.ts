import { Injectable } from '@angular/core';
import { HttpHeaders, HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Event } from 'src/app/classes/event';

@Injectable({
  providedIn: 'root'
})
export class EventService {
  private url = 'http://localhost/eventsManagement/public/index.php/api/';

  constructor(private http: HttpClient) { }

  getEvents(): Observable<Event[]> {
    return this.http.get<Event[]>(this.url + 'events', { responseType: 'json' });
  }

  getEvent(id: string): Observable<Event> {
    return this.http.get<Event>(this.url + 'event/' + id, { responseType: 'json' });
  }

  putEvent(id: number, event): Observable<any> {
    const httpOptions = {
      headers: new HttpHeaders({ 'Content-Type': 'application/json' })
    };

    return this.http.put(this.url + 'updateEvent/' + id, event, httpOptions);
  }

  postEvent(event): Observable<any> {
    const httpOptions = {
      headers: new HttpHeaders({ 'Content-Type': 'application/json' })
    };

    return this.http.post<any>(this.url + 'addEvent', event, httpOptions);
  }

  deleteEvent(id): Observable<any> {
    return this.http.delete(this.url +  'deleteEvent/' + id);
  }
}
