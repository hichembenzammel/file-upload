import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { ConcertHall } from '../models/hall';

@Injectable({
  providedIn: 'root'
})
export class ConcertHallService {

  private apiUrl = 'http://localhost:8000';

  constructor(private http: HttpClient) {}

  getConcertHalls(): Observable<any> {
    return this.http.get<any>(this.apiUrl+"/concerts");
  }

  createConcertHall(data: any): Observable<any> {
    return this.http.post<any>(`${this.apiUrl}/new`, data);
  }

  updateConcertHall(id: number, concertHall: ConcertHall): Observable<ConcertHall> {
    return this.http.put<ConcertHall>(`${this.apiUrl}/concert-halls/update/${id}`, concertHall);
  }

  deleteConcertHall(id: number): Observable<any> {
    return this.http.delete(`${this.apiUrl}/concert-halls/${id}`);
  }
}
