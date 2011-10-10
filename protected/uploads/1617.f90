program hello_world
include '/usr/include/mpi/mpif.h'
integer ierr
call MPI_INIT(ierr)
print *, "hello world"
call MPI_FINALIZE(ierr)
stop
end
