import { Component, OnInit } from '@angular/core';
import { ConcertHallService } from '../services/concert-hall.service';
import { ConcertHall } from '../models/hall';
import { FormsModule } from '@angular/forms';
import { CommonModule } from '@angular/common';
@Component({
  selector: 'app-concert-hall',
  standalone: true,
  imports: [FormsModule,CommonModule],
  templateUrl: './concert-hall.component.html',
  styleUrl: './concert-hall.component.css'
})


export class ConcertHallComponent implements OnInit {
  concertHalls: ConcertHall[] =[];
  selectedConcertHall: ConcertHall | null  = null;

  constructor(private concertHallService: ConcertHallService) {}

  ngOnInit(): void {
    this.loadConcertHalls();
  }

  loadConcertHalls() {
    this.concertHallService.getConcertHalls().subscribe((data) => {
      console.log(data);
      this.concertHalls = data;
    });
  }

  createConcertHall(name: string, location: string,date:string) {
    console.log(date)
    console.log(location)
    const newConcertHall = { name, location, date };
    this.concertHallService.createConcertHall(newConcertHall).subscribe(() => {
      this.loadConcertHalls(); 
    });
  }

  editConcertHall(hall: ConcertHall) {
    this.selectedConcertHall = { ...hall };
  }

  updateConcertHall() {
    if (this.selectedConcertHall) {
      this.concertHallService.updateConcertHall(this.selectedConcertHall.id, this.selectedConcertHall).subscribe(() => {
        this.loadConcertHalls();
        this.selectedConcertHall= { id: 0, name: '', location: '', date: '' };

      });
    }
  }

  deleteConcertHall(id: number) {
    if (confirm('Are you sure you want to delete this concert hall?')) {
      this.concertHallService.deleteConcertHall(id).subscribe(() => {
        this.loadConcertHalls(); 
      });
    }
  }
}