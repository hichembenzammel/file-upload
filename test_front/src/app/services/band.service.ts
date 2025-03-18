import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class BandService {

  private apiUrl = 'http://localhost:8000/';

  constructor(private http: HttpClient) {}

  getBands(): Observable<any> {
    return this.http.get<any>(this.apiUrl);
  }

  assignConcertHall(bandId: number, concertHallId: number): Observable<any> {
    return this.http.put<any>(`${this.apiUrl}assign-concerthall/${bandId}/${concertHallId}`,{});
  }
}
